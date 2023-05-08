<?php

namespace App\Observers;

use App\Models\EntityNote;
use App\Models\MapGroup;
use App\Models\MapLayer;

/**
 * Trait ReorderTrait
 * @package App\Observers
 */
trait ReorderTrait
{
    /**
     * @param mixed $model
     */
    public function reorder(mixed $model)
    {
        $position = 1;

        if ($model instanceof MapGroup) {
            foreach ($model->map->groups()->orderBy('position')->get() as $group) {
                $group->position = $position;
                $group->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($model instanceof MapLayer) {
            foreach ($model->map->layers()->orderBy('position')->get() as $layer) {
                $layer->position = $position;
                $layer->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($model instanceof EntityNote) {
            $posts = $model->entity->posts()->orderBy('position')->get();
            $position = $posts['0']->position;
            foreach ($posts as $post) {
                $post->position = $position;
                $post->updateQuietly();
                $position = $position + 1;
            }
        }
    }
}
