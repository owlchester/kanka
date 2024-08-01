<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\Map;
use App\Models\MiscModel;

class MapObserver extends MiscObserver
{
    public function saving(Map $map)
    {
        $map->grid = (int) $map->grid;
    }

    public function crudSaved(Map $map)
    {
        // Whenever we're saving a map, reset the size to force it to re-calculate. Maps shouldn't
        // be updated all that often (especially when using updateQuietly()) so hopefully this
        // doesn't cause too many performance issues.
        $map->height = null;
        $map->width = null;
        $map->saveQuietly();
    }

    /**
     * When an element is created, check for the copy option
     */
    public function created(MiscModel $model)
    {
        parent::created($model);

        // Copy eras from timeline
        if (request()->has('copy_elements') && request()->filled('copy_elements')) {
            $sourceId = request()->post('copy_source_id');

            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->isMap() && method_exists($source->child, 'copyRelatedToTarget')) {
                $source->child->copyRelatedToTarget($model);
            }
        }
    }
}
