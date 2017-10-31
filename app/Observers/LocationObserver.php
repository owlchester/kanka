<?php

namespace App\Observers;

use App\Campaign;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class LocationObserver
{
    /**
     * @param Location $location
     */
    public function saving(Location $location)
    {
        $location->slug = str_slug($location->name, '');
        $location->campaign_id = Session::get('campaign_id');

        // Purity text
        $location->history = Purify::clean($location->history);
        $location->description = Purify::clean($location->description);

        if (request()->has('image')) {
            $path = request()->file('image')->store('locations', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $location->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
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

    /**
     * @param Location $location
     */
    public function deleted(Location $location)
    {
        if (!empty($location->image)) {
            // Delete
            Storage::disk('public')->delete($location->image);
        }
    }

    /**
     * @param Location $location
     */
    public function deleting(Location $location)
    {
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

        foreach($location->locations as $sub) {
            $sub->location_id = null;
            $sub->save();
        }
    }
}
