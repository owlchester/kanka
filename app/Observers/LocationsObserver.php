<?php

namespace App\Observers;

use App\Facades\Domain;
use App\Models\Entity;
use App\Observers\Concerns\SaveLocations;

class LocationsObserver
{
    use SaveLocations;

    public function crudSaved(Entity $entity)
    {
        if ((! request()->has('save_locations') && ! request()->has('locations')) || (Domain::isApi() && ! request()->has('locations'))) {
            return;
        }
        $this->saveLocations($entity);
    }
}
