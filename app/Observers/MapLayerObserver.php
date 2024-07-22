<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\MapLayer;
use App\Facades\Images;

class MapLayerObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;
    use ReorderTrait;

    /**
     */
    public function saving(MapLayer $mapLayer)
    {
        $mapLayer->entry = $this->purify(Mentions::codify($mapLayer->entry));
        if (!empty($mapLayer->position)) {
            $mapLayer->position = (int) $mapLayer->position;
        } else {
            $lastLayer = $mapLayer->map->layers()->orderByDesc('position')->first();
            if ($lastLayer) {
                $mapLayer->position = (int)$lastLayer->position + 1;
            } else {
                $mapLayer->position = 1;
            }
        }

        // Trying to cheat the options
        if ($mapLayer->type_id > 2) {
            $mapLayer->type_id = null;
        }

        // When saving a map layer that has an image but no height, force the height and width
        // attribute to null to be handled in the ImageHandler. It uses getAttributes on the
        // model but these aren't present for some reason.
        if (empty($mapLayer->height)) {
            $mapLayer->height = 0;
            $mapLayer->width = 0;
        }

        // Handle image. Let's use a service for this.
        Images::handle($mapLayer, 'map_layers');
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
