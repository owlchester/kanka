<?php

namespace App\Policies;

use App\Models\Entity;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
{
    use HandlesAuthorization;

    public function entity(?User $user, Reminder $reminder, Entity $entity): bool
    {
        return $reminder->remindable_type === Entity::class && $reminder->remindable_id === $entity->id;
    }

    public function update(?User $user, Reminder $reminder)
    {
        return $user && $user->can('update', $reminder->calendar->entity);
    }

    public function delete(?User $user, Reminder $reminder)
    {
        return $user && $user->can('update', $reminder->calendar->entity);
    }
}
