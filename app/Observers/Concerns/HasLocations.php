<?php

namespace App\Observers\Concerns;

use App\Models\Creature;
use App\Models\Location;
use App\Models\MiscModel;

trait HasLocations
{
    /**
     * @param MiscModel|Creature $model
     */
    public function saveLocations(MiscModel|Creature $model)
    {
        /** @var Creature $model */
        $existing = $unique = $recreate = [];
        foreach ($model->locations as $location) {
            // If it already exists, we have an issue
            if (!empty($existing[$location->id])) {
                $recreate[$location->id] = $location->id;
                $model->locations()->detach($location->id);
                continue;
            }
            $existing[$location->id] = $location->id;
            $unique[$location->id] = $location->id;
        }

        if (!empty($recreate)) {
            $model->locations()->attach($recreate);
        }

        $locations = request()->get('locations', []);
        $newLocations = [];
        foreach ($locations as $id) {
            // Existing race, do nothing
            if (!empty($existing[$id])) {
                unset($existing[$id]);
                continue;
            }
            // If already managed, again, ignore
            if (!empty($unique[$id])) {
                continue;
            }

            $location = Location::find($id);
            if (empty($location)) {
                continue;
            }
            $newLocations[] = $location->id;
        }
        $model->locations()->attach($newLocations);

        // Detach the remaining
        if (!empty($existing)) {
            $model->locations()->detach($existing);
        }
    }
}
