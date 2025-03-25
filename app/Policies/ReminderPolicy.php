<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, Reminder $reminder)
    {
        return $user && $user->can('update', $reminder->calendar->entity);
    }

    public function delete(?User $user, Reminder $reminder)
    {
        return $user && $user->can('update', $reminder->calendar->entity);
    }
}
