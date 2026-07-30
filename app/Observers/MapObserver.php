<?php

namespace App\Observers;

use App\Events\Maps\Updated;
use App\Models\Map;

class MapObserver
{
    public function saving(Map $map)
    {
        $map->grid = (int) $map->grid;
    }

    public function updated(Map $map): void
    {
        if (! $map->wasChanged(['name', 'grid', 'min_zoom', 'max_zoom', 'config'])) {
            return;
        }

        Updated::dispatch($map);
    }
}
