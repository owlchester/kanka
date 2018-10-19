<?php

namespace App\Observers;

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
        if (request()->has('tags')) {
            // Don't want to run this twice. When creating a tag, it will call this function again.
            // Todo: better options?
            if (defined('MISCELLANY_DYNAMIC_TAG_CREATION')) {
                return;
            }
            define('MISCELLANY_DYNAMIC_TAG_CREATION', true);
            $ids = request()->post('tags');
            $existing = $entity->tags->pluck('name', 'id')->toArray();
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
        }
    }
}
