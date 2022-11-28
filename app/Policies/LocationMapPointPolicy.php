<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationMapPointPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.location');
    }
}
