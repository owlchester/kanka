<?php

namespace App\Observers;

use App\Models\MapLayer;
use App\Facades\Images;

class MapLayerObserver
{
    use ReorderTrait;

    /**
     */
    public function saving(MapLayer $mapLayer)
    {
        if (!empty($mapLayer->position)) {
            $mapLayer->position = (int) $mapLayer->position;
        } else {
            /** @var ?MapLayer $lastLayer */
            $lastLayer = $mapLayer->map->layers()->orderByDesc('position')->first();
            if ($lastLayer) {
                $mapLayer->position = (int) $lastLayer->position + 1;
            } else {
                $mapLayer->position = 1;
            }
        }

        // Trying to cheat the options
        if ($mapLayer->type_id > 2) {
            $mapLayer->type_id = null;
        }
    }

    /**
     */
    public function deleted(MapLayer $mapLayer)
    {
        Images::cleanup($mapLayer);
        $mapLayer->map->touch();
    }

    /**
     */
    public function saved(MapLayer $mapLayer)
    {
        $this->reorder($mapLayer);
        $mapLayer->map->touchSilently();
    }
}
