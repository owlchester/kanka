<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Events\Maps\LayerChanged;
use App\Facades\Images;
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

    public function deleted(MapLayer $mapLayer)
    {
        Images::model($mapLayer)->cleanup();
        $mapLayer->map->touchSilently();
        $this->broadcastChange($mapLayer, 'deleted');
    }

    public function saved(MapLayer $mapLayer)
    {
        $this->reorder($mapLayer);
        $mapLayer->map->touchSilently();
    }

    public function created(MapLayer $mapLayer): void
    {
        if (! $mapLayer->isExplorable()) {
            return;
        }

        $this->broadcastChange($mapLayer, 'created');
    }

    public function updated(MapLayer $mapLayer): void
    {
        $mapLayer->unsetRelation('image');
        $this->broadcastChange($mapLayer, $mapLayer->isExplorable() ? 'updated' : 'deleted');
    }

    protected function broadcastChange(MapLayer $mapLayer, string $action): void
    {
        if (! in_array($mapLayer->visibility_id, [Visibility::All, Visibility::Member], true)) {
            return;
        }

        LayerChanged::dispatch($mapLayer, $action);
    }
}
