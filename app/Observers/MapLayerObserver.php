<?php

namespace App\Observers;

use App\Events\Maps\ContentsChanged;
use App\Facades\Images;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use App\Services\Maps\TilingTriggerService;

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
        $this->maybeTriggerTiling($mapLayer);
    }

    public function updated(MapLayer $mapLayer): void
    {
        if ($mapLayer->wasChanged('position')) {
            $this->reorder($mapLayer);
        }
        $this->broadcastContents($mapLayer->map);

        if ($mapLayer->wasChanged('image_uuid')) {
            $this->maybeTriggerTiling($mapLayer);
        }
    }

    protected function maybeTriggerTiling(MapLayer $mapLayer): void
    {
        if (! $mapLayer->image_uuid) {
            return;
        }

        $image = Image::find($mapLayer->image_uuid);
        if ($image) {
            app(TilingTriggerService::class)->maybeTrigger($image);
        }
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
