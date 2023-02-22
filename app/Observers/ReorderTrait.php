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
     * @param MapGroup $mapGroup
     * @param MapLayer $mapLayer
     */
    public function reorder(MapGroup $mapGroup = null, MapLayer $mapLayer = null, EntityNote $post = null)
    {
        $position = 1;

        if ($mapGroup) {
            foreach ($mapGroup->map->groups()->orderBy('position')->get() as $group) {
                $group->position = $position;
                $group->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($mapLayer) {
            foreach ($mapLayer->map->layers()->orderBy('position')->get() as $layer) {
                $layer->position = $position;
                $layer->updateQuietly();
                $position = $position + 1;
            }
        } elseif ($post) {
            foreach ($post->entity->posts()->orderBy('position')->get() as $post) {
                $post->position = $position;
                $post->updateQuietly();
                $position = $position + 1;
            }
        }
    }
}
