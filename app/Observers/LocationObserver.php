<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class LocationObserver extends MiscObserver
{
    /**
     * @param Location $location
     */
    public function saving(MiscModel $location)
    {
        parent::saving($location);

        $nullable = ['parent_location_id'];
        foreach ($nullable as $attr) {
            $location->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * @param Location $location
     */
    public function deleting(MiscModel $location)
    {
        parent::deleting($location);

        foreach ($location->characters as $character) {
            $character->location_id = null;
            $character->save();
        }

        foreach ($location->families as $family) {
            $family->location_id = null;
            $family->save();
        }

        foreach ($location->items as $item) {
            $item->location_id = null;
            $item->save();
        }

        foreach ($location->locations as $sub) {
            $sub->parent_location_id = null;
            $sub->save();
        }
    }
}
