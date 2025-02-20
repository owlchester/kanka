<?php

namespace App\Policies;

use App\Models\EntityEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityEventPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, EntityEvent $entityEvent)
    {
        return $user && $user->can('update', $entityEvent->calendar->entity);
    }

    public function delete(?User $user, EntityEvent $entityEvent)
    {
        return $user && $user->can('update', $entityEvent->calendar->entity);
    }
}
