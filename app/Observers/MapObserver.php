<?php

namespace App\Observers;

use App\Models\Map;

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
}
