<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.calendar');
    }
}
