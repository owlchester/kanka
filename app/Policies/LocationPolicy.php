<?php

namespace App\Policies;

use App\User;
use App\Models\Location;

class LocationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.location');
    }
}
