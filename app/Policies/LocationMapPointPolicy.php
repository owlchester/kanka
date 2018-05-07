<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationMapPointPolicy extends EntityPolicy
{
    protected $model = 'location';
}
