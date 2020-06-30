<?php


namespace App\Observers;


use App\Facades\Mentions;
use App\Models\MapLayer;
use App\Services\ImageService;

class MapLayerObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param MapLayer $mapLayer
     */
    public function saving(MapLayer $mapLayer)
    {
        $mapLayer->entry = $this->purify(Mentions::codify($mapLayer->entry));
        if (!empty($mapLayer->positon)) {
            $mapLayer->position = (int) $mapLayer->position;
        }

        // Handle image. Let's use a service for this.
        ImageService::handle($mapLayer, 'map_markers');
    }

    /**
     * @param MapLayer $mapLayer
     */
    public function deleted(MapLayer $mapLayer)
    {
        ImageService::cleanup($mapLayer);
    }

}
