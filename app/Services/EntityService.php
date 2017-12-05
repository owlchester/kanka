<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\MiscModel;
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
                $singular = rtrim($entity, 's');
                if ($entity == 'families') {
                    $singular = 'family';
                }
                $labels[$entity] = trans('entities.' . $singular);
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

        // Update entity
        $entity->type = $new->getEntityType();
        $entity->entity_id = $new->id;
        $entity->save();


        // Delete old, this will take care of pictures and stuff
        $old->delete();

        return $entity;
    }
}
