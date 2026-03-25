<?php

namespace App\Policies;

use App\Models\CalendarEra;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarEraPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, CalendarEra $calendarEra)
    {
        return $user && $user->can('update', $calendarEra->calendar->entity);
    }

    public function delete(?User $user, CalendarEra $calendarEra)
    {
        return $user && $user->can('update', $calendarEra->calendar->entity);
    }
}
