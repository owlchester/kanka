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
}
