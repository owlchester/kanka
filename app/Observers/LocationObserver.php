<?php

namespace App\Observers;

use App\Campaign;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LocationObserver
{
    /**
     * @param Location $location
     */
    public function saving(Location $location)
    {
        $location->slug = str_slug($location->name, '');
        $location->campaign_id = Session::get('campaign_id');

        if (request()->has('image')) {
            $path = request()->file('image')->store('locations', 'public');
            if (!empty($path)) {
                // Remove old?
                if (!empty($location->image)) {
                    // Delete
                }
                $location->image = $path;
            }
        }
    }

    /**
     * @param Location $location
     */
    public function saved(Location $location)
    {
    }

    /**
     * @param Location $location
     */
    public function created(Location $location)
    {
    }
}
