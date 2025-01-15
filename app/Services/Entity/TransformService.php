<?php

namespace App\Services\Entity;

use App\Facades\EntityLogger;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Post;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Exception;

class TransformService
{
    use CampaignAware;
    use EntityAware;
    use EntityTypeAware;

    protected MiscModel $child;
    protected MiscModel|Entity $new;
    protected array $fillable;

    public function child(MiscModel $child): self
    {
        $this->child = $child;
        $this->entity = $child->entity;
        return $this;
    }

    public function transform(): Entity
    {
        // Custom to custom, just update the type_id
        if ($this->entity->entityType->isSpecial() && $this->entityType->isSpecial()) {
            $this->entity->type_id = $this->entityType->id;
            $this->entity->save();
            return $this->entity;
        }

        // Custom to child
        if ($this->entity->entityType->isSpecial() && !$this->entityType->isSpecial()) {
            return $this->specialToMisc();
        } elseif (!$this->entity->entityType->isSpecial() && $this->entityType->isSpecial()) {
            return $this->miscToSpecial();
        }

        if (empty($this->child) && $this->entity->hasChild()) {
            $this->child = $this->entity->child;
        }

        $this->new = $this->entityType->getClass();

        $this
            ->attributes()
            ->location()
            ->removePosts()
        ;

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
        // Special import for location location_id
        if (in_array('location_id', $this->fillable) && empty($this->new->location_id) && !empty($this->child->location_id)) {
            // @phpstan-ignore-next-line
            $this->new->location_id = $this->child->{$this->child->getParentKeyName()};
        }
        if (in_array('location_id', $this->fillable) && empty($this->new->location_id) && !empty($this->child->location_id)) {
            // @phpstan-ignore-next-line
            $this->new->setParentId($this->child->location_id);
        }

        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');
        $organisationID = config('entities.ids.organisation');

        // @phpstan-ignore-next-line
        if (in_array($this->child->entityTypeId(), [$raceID, $creatureID, $organisationID]) && !in_array($this->new->entityTypeId(), [$raceID, $creatureID, $organisationID]) && !empty($this->child->locations()->first())) {
            if (in_array('location_id', $this->fillable)) {
                // @phpstan-ignore-next-line
                $this->new->location_id = $this->child->locations()->first()->id;
            } elseif (in_array('location_id', $this->fillable)) {
                // @phpstan-ignore-next-line
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
        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');
        $organisationID = config('entities.ids.organisation');

        //If the entity is switched from one location to multiple locations
        if (!in_array($this->child->entityTypeId(), [$raceID, $creatureID, $organisationID]) && in_array($this->new->entityTypeId(), [$raceID, $creatureID, $organisationID])) {
            if (in_array('location_id', $this->child->getFillable()) && !empty($this->child->location_id)) {
                // @phpstan-ignore-next-line
                $this->new->locations()->attach($this->child->location_id);
            } elseif (in_array('location_id', $this->child->getFillable()) && !empty($this->child->location_id)) {
                // @phpstan-ignore-next-line
                $this->new->locations()->attach($this->child->location_id);
            }
            return $this;
        }

        if (
            !in_array($this->child->entityTypeId(), [$raceID, $creatureID, $organisationID]) ||
            !in_array($this->new->entityTypeId(), [$raceID, $creatureID, $organisationID])
        ) {
            if (property_exists($this->child, 'locations')) {
                // @phpstan-ignore-next-line
                $this->child->locations()->sync([]);
            }
            return $this;
        }

        // @phpstan-ignore-next-line
        foreach ($this->child->locations as $loc) {
            // @phpstan-ignore-next-line
            $this->new->locations()->attach($loc->id);
        }
        // @phpstan-ignore-next-line
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

    protected function removePosts(): self
    {
        //Delete non compatible posts.
        Post::where('entity_id', $this->entity->id)
            ->leftJoin('post_layouts', 'posts.layout_id', '=', 'post_layouts.id')
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
        if (
            $this->child->entityTypeId() == config('entities.ids.organisation') &&
            $this->new->entityTypeId() == config('entities.ids.family')
        ) {
            // @phpstan-ignore-next-line
            foreach ($this->child->members as $member) {
                $member->delete();
                // @phpstan-ignore-next-line
                $this->new->members()->attach($member->character_id);
            }
        } elseif (
            $this->child->entityTypeId() == config('entities.ids.family') &&
            $this->new->entityTypeId() == config('entities.ids.organisation')
        ) {
            // @phpstan-ignore-next-line
            foreach ($this->child->members as $character) {
                $orgMember = new OrganisationMember();
                $orgMember->character_id = $character->id;
                $orgMember->organisation_id = $this->new->id;
                $orgMember->role = '';
                $orgMember->save();
                // @phpstan-ignore-next-line
                $this->child->members()->detach($character->id);
            }
        } else {
            // Remove members when they aren't characters
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
        if ($this->child->entityTypeId() != config('entities.ids.character')) {
            return $this;
        }
        // @phpstan-ignore-next-line
        foreach ($this->child->conversationParticipants as $conPar) {
            $conPar->delete();
        }
        return $this;
    }

    protected function finish(): self
    {
        $type = $this->entity->entityType->name();
        // Update entity to its new type. We don't use a new entity to keep all mentions, attributes and
        // other related elements attached.
        $this->entity->type_id = $this->entityType->id;
        // If attached to a misc model, save the entity_id
        if (isset($this->new)) {
            $this->entity->entity_id = $this->new->id;
        }
        $this->entity->cleanCache()->saveQuietly();

        EntityLogger::entity($this->entity)->dirty('entity_type', $type)->update();

        // Delete old, this will take care of pictures and stuff. We detach the
        // entity to avoid the softDelete affecting it and causing duplicate
        // entities in the db. ForceDelete the MiscModel for img cleanup.
        if (isset($this->child)) {
            $this->child->entity = null;

            // Change the permission's misc_id to be the new one
            if (isset($this->new)) {
                CampaignPermission::where('entity_id', $this->entity->id)
                    ->where('misc_id', $this->child->id)
                    ->update(['misc_id' => $this->new->id]);
            } else {
                CampaignPermission::where('entity_id', $this->entity->id)
                    ->where('misc_id', $this->child->id)
                    ->update(['misc_id' => null]);
            }

            // Force delete the old entity to avoid it creating weird issues in the db by being soft deleted.
            $this->child->forceDelete();
        }

        return $this;
    }

    protected function specialToMisc(): Entity
    {
        // Create misc
        $this->new = $this->entityType->getClass();
        $this->new->name = $this->entity->name;
        $this->new->is_private = $this->entity->is_private;
        $this->new->campaign_id = $this->campaign->id;
        $this->new->save();

        $this->finish();


        return $this->entity;
    }

    protected function miscToSpecial(): Entity
    {
        $this->child = $this->entity->child;

        $this->finish();

        return $this->entity;
    }
}
