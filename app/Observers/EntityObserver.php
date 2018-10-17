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
        $this->saveSections($entity);
    }

    /**
     * Save the sections/categories
     */
    protected function saveSections(Entity $entity)
    {
        if (request()->has('tags')) {
            $ids = request()->post('tags');
            $existing = $entity->tags->pluck('name', 'id')->toArray();
            $new = [];

            foreach ($ids as $id) {
                if (!empty($existing[$id])) {
                    unset($existing[$id]);
                } else {
                    $section = Tag::findOrFail($id);
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
