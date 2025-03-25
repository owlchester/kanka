<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\CampaignRoleUserJob;
use App\Models\CampaignRoleUser;

class CampaignRoleUserObserver
{
    public function created(CampaignRoleUser $campaignRoleUser)
    {
        CampaignRoleUserJob::dispatch($campaignRoleUser, true);
        UserCache::user($campaignRoleUser->user)->clear();
    }

    public function deleted(CampaignRoleUser $campaignRoleUser)
    {
        CampaignRoleUserJob::dispatch($campaignRoleUser, false);
        UserCache::user($campaignRoleUser->user)->clear();
        CampaignCache::campaign($campaignRoleUser->campaignRole->campaign)->clear();
    }
}
