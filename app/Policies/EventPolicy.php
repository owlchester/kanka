<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy extends EntityPolicy
{
    protected $model = 'event';
}
