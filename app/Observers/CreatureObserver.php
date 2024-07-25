<?php

namespace App\Observers;

use App\Models\Creature;
use App\Observers\Concerns\HasLocations;

class CreatureObserver extends MiscObserver
{
    use HasLocations;

    /**
     */
    public function crudSaved(Creature $creature)
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return;
        }
        $this->saveLocations($creature);
    }
}
