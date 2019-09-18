<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy extends MiscPolicy
{
    protected $model = 'calendar';
}
