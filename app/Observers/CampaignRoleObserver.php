<?php

namespace App\Observers;

use App\Events\Campaigns\Roles\RoleCreated;
use App\Events\Campaigns\Roles\RoleDeleted;
use App\Events\Campaigns\Roles\RoleUpdated;
use App\Models\CampaignRole;

class CampaignRoleObserver
{
    public function created(CampaignRole $campaignRole)
    {
        RoleCreated::dispatch($campaignRole, auth()->user());
    }

    public function deleted(CampaignRole $campaignRole)
    {
        RoleDeleted::dispatch($campaignRole, auth()->user());
    }

    public function updated(CampaignRole $campaignRole)
    {
        RoleUpdated::dispatch($campaignRole, auth()->user());
    }
}
