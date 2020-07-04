<?php


namespace App\Observers;


use App\Facades\Mentions;
use App\Models\MapMarker;

class MapMarkerObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param MapMarker $mapMarker
     */
    public function saving(MapMarker $mapMarker)
    {
        $mapMarker->entry = $this->purify(Mentions::codify($mapMarker->entry));
    }

    /**
     * @param MapMarker $mapMarker
     */
    public function saved(MapMarker $mapMarker)
    {
        $mapMarker->map->touch();
    }

    /**
     * @param MapMarker $mapMarker
     */
    public function deleted(MapMarker $mapMarker)
    {
        $mapMarker->map->touch();
    }
}
