<?php

namespace App\Observers;

use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Tag;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class EntityObserver
{
    // not used

    /**
     * An entity has been saved.
     */
    public function saved(Entity $entity)
    {
        $this->saveTags($entity);
    }

    /**
     * Save the sections/categories
     */
    protected function saveTags(Entity $entity)
    {
        //if (request()->has('tags')) {
            // Don't want to run this twice. When creating a tag, it will call this function again.
            // Todo: better options?
            if (defined('MISCELLANY_DYNAMIC_TAG_CREATION')) {
                return;
            }
            define('MISCELLANY_DYNAMIC_TAG_CREATION', true);
            $ids = request()->post('tags', []);

            // Only use tags the user can actually view. This way admins can
            // have tags on entities that the user doesn't know about.
            $existing = [];
            foreach ($entity->tags()->with('entity')->get() as $tag) {
                if (EntityPermission::canView($tag->entity)) {
                    $existing[$tag->id] = $tag->name;
                }
            }
            $new = [];

            foreach ($ids as $id) {
                if (!empty($existing[$id])) {
                    unset($existing[$id]);
                } else {
                    $section = Tag::find($id);
                    if (empty($section)) {
                        // Create it, the id contains the name
                        $section = Tag::create([
                            'name' => $id
                        ]);
                    }
                    $new[] = $section->id;
                }
            }
            $entity->tags()->attach($new);

            // Detatch the remaining
            if (!empty($existing)) {
                $entity->tags()->detach(array_keys($existing));
            }
        //}
    }

    public function created(Entity $entity)
    {
        // If the user has created a new entity but doesn't have the permission to read or edit it,
        // automatically create said permission.
        if (!auth()->user()->can('view', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->user_id = auth()->user()->id;
            $permission->key = $entity->type . '_read_' . $entity->child->id;
            $permission->table_name = $entity->pluralType();
            $permission->save();
        }
        if (!auth()->user()->can('update', $entity->child)) {
            $permission = new CampaignPermission();
            $permission->entity_id = $entity->id;
            $permission->user_id = auth()->user()->id;
            $permission->key = $entity->type . '_edit_' . $entity->child->id;
            $permission->table_name = $entity->pluralType();
            $permission->save();
        }
    }

    /**
     * @param Entity $entity
     */
    public function deleting(Entity $entity)
    {
        // Delete permissions related to this entity
        $entity->permissions()->delete();
    }
}
