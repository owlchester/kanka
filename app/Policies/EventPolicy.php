<?php

namespace App\Policies;

use App\Models\CampaignPermission;
use App\User;

class EventPolicy extends MiscPolicy
{
    protected $model = 'event';


    /**
     * Determine whether the user can create entitys.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function calendar(User $user)
    {
        return $this->checkPermission(CampaignPermission::ACTION_ADD, $user);
    }
}
