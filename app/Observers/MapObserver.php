<?php

namespace App\Observers;

use App\Models\Map;

class MapObserver extends MiscObserver
{
    public function saving(Map $map)
    {
        $map->grid = (int) $map->grid;
    }
}
