<?php

namespace App\Observers;

use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;
use App\Models\CampaignRoleUser;

class CampaignRoleUserObserver
{
    public function created(CampaignRoleUser $campaignRoleUser)
    {
        RoleUserAdded::dispatch($campaignRoleUser, auth()->user());
    }

    public function deleted(CampaignRoleUser $campaignRoleUser)
    {
        RoleUserRemoved::dispatch($campaignRoleUser, auth()->user());
    }
}
