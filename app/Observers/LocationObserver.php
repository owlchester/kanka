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
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Handle image. Let's use a service for this.
        ImageService::handle($model, $model->getTable(), 60, 'map');
    }

    /**
     * @param Location $location
     */
    public function deleting(MiscModel $location)
    {
        parent::deleting($location);

        // Todo: remove this and update schema instead
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

        foreach ($location->organisations as $sub) {
            $sub->location_id = null;
            $sub->save();
        }

        ImageService::cleanup($location, 'map');
    }
}
