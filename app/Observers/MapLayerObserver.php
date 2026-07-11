<?php

namespace App\Observers;

use App\Events\Maps\ContentsChanged;
use App\Facades\Images;
use App\Models\Map;
use App\Models\MapLayer;

class MapLayerObserver
{
    use ReorderTrait;

    public function saving(MapLayer $mapLayer)
    {
        if (! empty($mapLayer->position)) {
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

    public function saved(MapLayer $mapLayer)
    {
        $mapLayer->map->touchSilently();
    }

    public function created(MapLayer $mapLayer): void
    {
        $this->reorder($mapLayer);
        $this->broadcastContents($mapLayer->map);
    }

    public function updated(MapLayer $mapLayer): void
    {
        if ($mapLayer->wasChanged('position')) {
            $this->reorder($mapLayer);
        }
        $this->broadcastContents($mapLayer->map);
    }

    public function deleted(MapLayer $mapLayer)
    {
        Images::model($mapLayer)->cleanup();
        $mapLayer->map->touchSilently();
        $this->broadcastContents($mapLayer->map);
    }

    protected function broadcastContents(Map $map): void
    {
        ContentsChanged::dispatch($map);
        ContentsChanged::dispatch($map, true);
    }
}
