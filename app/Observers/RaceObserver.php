<?php

namespace App\Observers;

use App\Models\Race;
use App\Observers\Concerns\HasLocations;

class RaceObserver extends MiscObserver
{
    use HasLocations;

    public function crudSaved(Race $race)
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return $this;
        }
        $this->saveLocations($race);
    }

    public function deleting(Race $race)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($race->races as $sub) {
            $sub->race_id = null;
            $sub->saveQuietly();
        }
    }
}
