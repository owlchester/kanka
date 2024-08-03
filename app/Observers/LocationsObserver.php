<?php

namespace App\Observers;

use App\Observers\Concerns\SaveLocations;
use Illuminate\Database\Eloquent\Model;

class LocationsObserver
{
    use SaveLocations;

    /**
     */
    public function crudSaved(Model $model)
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return;
        }
        $this->saveLocations($model);
    }
}
