<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use Illuminate\Support\Facades\Storage;

class EntityService
{
    /**
     * @var array
     */
    protected $entities = [];

    /**
     * EntityService constructor.
     */
    public function __construct()
    {
        $this->entities = [
            'characters' => 'App\Models\Character',
            'events' => 'App\Models\Event',
            'families' => 'App\Models\Family',
            'items' => 'App\Models\Item',
            'journals' => 'App\Models\Journal',
            'locations' => 'App\Models\Location',
            'notes' => 'App\Models\Note',
            'organisations' => 'App\Models\Organisation',
            'quests' => 'App\Models\Quest',
        ];
    }

    /**
     * Get the entities
     *
     * @return array
     */
    public function entities()
    {
        return $this->entities;
    }

    /**
     * Get labelled entities
     *
     * @param bool $singular
     * @param null $ignore
     * @return array
     */
    public function labelledEntities($singular = true, $ignore = null)
    {
        $labels = [];
        foreach ($this->entities() as $entity => $class) {
            if ($singular) {
                $labels[$entity] = trans('entities.' . $this->singular($entity));
            } else {
                $labels[$entity] = trans('entities.' . $entity);
            }
        }

        if (!empty($ignore) && !empty($labels[$ignore])) {
            unset($labels[$ignore]);
        }

        return $labels;
    }

    /**
     * @param $entity
     * @return string
     */
    public function singular($entity)
    {
        $singular = rtrim($entity, 's');
        if ($entity == 'families') {
            $singular = 'family';
        }
        return $singular;
    }

    /**
     * Move an entity to another type
     *
     * @param Entity $entity
     * @param String $target
     * @return Entity
     */
    public function move(Entity $entity, $target)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown target '$target' for moving entity");
        }
        /**
         * @var $new MiscModel
         */
        $new = new $this->entities[$target]();
        $newAttributes = $new->getAttributes();
        $old = $entity->child;

        // Move attributes
        $oldAttributes = $old->getAttributes();
        unset($oldAttributes['id']);

        $fillable = $new->getFillable();
        foreach ($oldAttributes as $attribute => $value) {
            if (in_array($attribute, $fillable)) {
                $new->{$attribute} = $value;
            }
        }

        // Special support for description/history
        if (in_array('description', $fillable) && empty($new->description) && !empty($old->history)) {
            $new->description = $old->history;
        }
        if (in_array('history', $fillable) && empty($new->history) && !empty($old->description)) {
            $new->history = $old->description;
        }
        // Special import for location parent_location_id
        if (in_array('location_id', $fillable) && empty($new->location_id) && !empty($old->parent_location_id)) {
            $new->location_id = $old->parent_location_id;
        }
        if (in_array('parent_location_id', $fillable) && empty($new->parent_location_id) && !empty($old->location_id)) {
            $new->parent_location_id = $old->location_id;
        }

        // Copy file
        if (!empty($new->image)) {
            $newPath = str_replace($old->getTable(), $new->getTable(), $old->image);
            $new->image = $newPath;
            if (!Storage::disk('public')->exists($newPath)) {
                Storage::disk('public')->copy($old->image, $newPath);
            }

            // Copy thumb
            $oldThumb = str_replace('.', '_thumb.', $old->image);
            $newThumb = str_replace($old->getTable(), $new->getTable(), $oldThumb);
            if (!Storage::disk('public')->exists($newThumb)) {
                Storage::disk('public')->copy($oldThumb, $newThumb);
            }
        }

        // Finally, we can save. Should be all good. But tell the app not to create the entity
        define('MISCELLANY_SKIP_ENTITY_CREATION', true);
        $new->save();

        // If switching from an organisation to a family, we need to move the members?
        if ($old->getEntityType() == 'organisation' && $new->getEntityType() == 'family') {
            foreach ($old->members as $member) {
                if (empty($member->character->family_id)) {
                    $member->character->family_id = $new->id;
                    $member->character->save();
                }
                $member->delete();
            }
        } elseif ($old->getEntityType() == 'family' && $new->getEntityType() == 'organisation') {
            $characters = Character::where('family_id', $old->id)->get();
            foreach ($characters as $character) {
                $orgMember = new OrganisationMember();
                $orgMember->character_id = $character->id;
                $orgMember->organisation_id = $new->id;
                $orgMember->role = '';
                $orgMember->save();

                $character->family_id = null;
                $character->save();
            }
        } else {
            // But remove old members none the less
            if (isset($old->members)) {
                foreach ($old->members as $member) {
                    $member->delete();
                }
            }
        }

        // Update entity
        $entity->type = $new->getEntityType();
        $entity->entity_id = $new->id;
        $entity->save();


        // Delete old, this will take care of pictures and stuff
        $old->delete();

        return $entity;
    }

    /**
     * @param $name
     * @param $target
     * @return MiscModel
     * @throws \Exception
     */
    public function create($name, $target)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown target '$target' for moving entity");
        }

        /**
         * @var $new MiscModel
         */
        $new = new $this->entities[$target]();
        $new->name = $name;
        $new->is_private = false;
        $new->save();
        return $new;
    }
}
