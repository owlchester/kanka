<?php

namespace App\Policies;

use App\Models\CampaignPermission;
use App\Models\User;

class EventPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.event');
    }

    public function calendar(User $user)
    {
        return $this->checkPermission(CampaignPermission::ACTION_ADD, $user);
    }
}
