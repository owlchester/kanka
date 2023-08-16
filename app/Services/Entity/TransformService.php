<?php

namespace App\Services\Entity;

use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\Family;
use App\Models\Item;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Race;
use App\Traits\CanFixTree;
use App\Traits\EntityAware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class TransformService
{
    use EntityAware;
    use CanFixTree;

    protected MiscModel $child;
    protected MiscModel $new;
    protected array $fillable;

    public function child(MiscModel $child): self
    {
        $this->child = $child;
        $this->entity = $child->entity;
        return $this;
    }

    public function transform(string $target): Entity
    {
        if (empty($this->child)) {
            $this->child = $this->entity->child;
        }
        $this->new = $this->new($target);

        $this
            ->attributes()
            ->location()
            ->image()
            ->removeTags()
            ->removePosts()
        ;

        $this->fixTree($this->new);

        // Finally, we can save. Should be all good.
        $this->new->campaign_id = $this->child->campaign_id;
        $this->new->saveQuietly();

        $this
            ->members()
            ->participants()
            ->locations();

        $this->finish();

        return $this->entity;
    }

    protected function location(): self
    {
        // Special import for location parent_location_id
        /** @var Location $this->child */
        /** @var Item $new */
        if (in_array('location_id', $this->fillable) && empty($this->new->location_id) && !empty($this->child->parent_location_id)) {
            $this->new->location_id = $this->child->getParentId();
        }
        /** @var Item $this->child */
        /** @var Location $new */
        if (in_array('parent_location_id', $this->fillable) && empty($this->new->parent_location_id) && !empty($this->child->location_id)) {
            $this->new->setParentId($this->child->location_id);
        }

        /** @var Race|Creature $old */
        /** @var Creature|Race $new */
        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');

        if (in_array($this->child->entityTypeId(), [$raceID, $creatureID]) && !in_array($this->new->entityTypeId(), [$raceID, $creatureID]) && !empty($this->child->locations()->first())) {
            if (in_array('location_id', $this->fillable)) {
                /** @var Character $this->new */
                $this->new->location_id = $this->child->locations()->first()->id;
            } elseif (in_array('parent_location_id', $this->fillable)) {
                // Todo: fix crash when location is empty
                $this->new->setParentId($this->child->locations()->first()->id);
            }
        }

        return $this;
    }

    /**
     * For entities with multiple locations, they can sometimes be moved around
     */
    protected function locations(): self
    {
        /** @var Race|Creature $old */
        /** @var Creature|Race $new */
        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');

        //If the entity is switched from one location to multiple locations
        if (!in_array($this->child->entityTypeId(), [$raceID, $creatureID]) && in_array($this->new->entityTypeId(), [$raceID, $creatureID])) {
            if (in_array('parent_location_id', $this->child->getFillable()) && !empty($this->child->parent_location_id)) {
                $this->new->locations()->attach($this->child->parent_location_id);
            } elseif (in_array('location_id', $this->child->getFillable()) && !empty($this->child->location_id)) {
                $this->new->locations()->attach($this->child->location_id);
            }
            return $this;
        }

        if (
            !in_array($this->child->entityTypeId(), [$raceID, $creatureID]) ||
            !in_array($this->new->entityTypeId(), [$raceID, $creatureID])
        ) {
            if (property_exists($this->child, 'locations')) {
                $this->child->locations()->sync([]);
            }
            return $this;
        }

        foreach ($this->child->locations as $loc) {
            $this->new->locations()->attach($loc->id);
        }
        $this->child->locations()->sync([]);
        return $this;
    }

    protected function new(string $class): MiscModel
    {
        $class = '\App\Models\\' . Str::studly($class);
        try {
            return app()->make($class);
        } catch (Exception $e) {
            throw new Exception("Unknown target '{$class}' for transforming entity");
        }
    }

    protected function attributes(): self
    {
        $oldAttributes = $this->child->getAttributes();
        unset($oldAttributes['id']);

        $this->fillable = $this->new->getFillable();
        foreach ($oldAttributes as $attribute => $value) {
            if (in_array($attribute, $this->fillable)) {
                $this->new->{$attribute} = $value;
            }
        }
        return $this;
    }

    protected function image(): self
    {
        if (empty($this->new->image)) {
            return $this;
        }
        $newPath = str_replace($this->child->getTable(), $this->new->getTable(), $this->child->image);
        $this->new->image = $newPath;
        if (!Storage::exists($newPath)) {
            Storage::copy($this->child->image, $newPath);
        }

        return $this;
    }

    /**
     * Remove tags if converting to tag, since tags can't have tags.
     * @return $this
     */
    protected function removeTags(): self
    {
        if ($this->new->entityTypeId() != config('entities.ids.tag')) {
            return $this;
        }
        $this->entity->tags()->detach();
        return $this;
    }

    protected function removePosts(): self
    {
        //Delete non compatible posts.
        EntityNote::where('entity_id', $this->entity->id)
            ->leftJoin('post_layouts', 'entity_notes.layout_id', '=', 'post_layouts.id')
            ->whereNotNull('post_layouts.entity_type_id')
            ->delete();
        return $this;
    }

    /**
     * If switching from an organisation to a family, we need to move the members?
     * @return $this
     */
    protected function members(): self
    {
        /** @var Organisation|Family $this->child */
        /** @var Family|Organisation $new */
        if (
            $this->child->entityTypeId() == config('entities.ids.organisation') &&
            $this->new->entityTypeId() == config('entities.ids.family')
        ) {
            foreach ($this->child->members as $member) {
                $member->delete();
                $this->new->members()->attach($member->character_id);
            }
        } elseif (
            $this->child->entityTypeId() == config('entities.ids.family') &&
            $this->new->entityTypeId() == config('entities.ids.organisation')
        ) {
            foreach ($this->child->members as $character) {
                $orgMember = new OrganisationMember();
                $orgMember->character_id = $character->id;
                $orgMember->organisation_id = $this->new->id;
                $orgMember->role = '';
                $orgMember->save();
                $this->child->members()->detach($character->id);
            }
        } else {
            // Remove members when they aren't characters
            /** @var Family $old */
            if (isset($this->child->members)) {
                foreach ($this->child->members as $member) {
                    // We make sure this isn't a character, because a family has members which are
                    // directly characters while orgs have members which are an in between entity.
                    if (!$member instanceof Character) {
                        $member->delete();
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Remove the old participants from a convo
     * @return $this
     */
    protected function participants(): self
    {
        /** @var Character $old */
        if ($this->child->entityTypeId() != config('entities.ids.character')) {
            return $this;
        }
        foreach ($this->child->conversationParticipants as $conPar) {
            $conPar->delete();
        }
        return $this;
    }

    protected function finish(): self
    {
        // Update entity to its new type. We don't use a new entity to keep all mentions, attributes and
        // other related elements attached.
        $this->entity->type_id = $this->new->entityTypeID();
        $this->entity->entity_id = $this->new->id;
        $this->entity->cleanCache()->save();

        // Delete old, this will take care of pictures and stuff. We detach the
        // entity to avoid the softDelete affecting it and causing duplicate
        // entities in the db. ForceDelete the MiscModel for img cleanup.
        $this->child->entity = null;

        // Change the permission's misc_id to be the new one
        CampaignPermission::where('entity_id', $this->entity->id)
            ->where('misc_id', $this->child->id)
            ->update(['misc_id' => $this->new->id]);

        // Force delete the old entity to avoid it creating weird issues in the db by being soft deleted.
        $this->child->forceDelete();

        return $this;
    }
}
