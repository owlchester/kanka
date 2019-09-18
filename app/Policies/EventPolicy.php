<?php

namespace App\Policies;

use App\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy extends MiscPolicy
{
    protected $model = 'event';


    /**
     * Determine whether the user can create entitys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function calendar(User $user)
    {
        return $this->checkPermission('add', $user);
    }
}
