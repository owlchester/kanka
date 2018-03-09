<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy extends EntityPolicy
{
    protected $model = 'location';
}
