<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignRole;

class CampaignRoleObserver
{
    /**
     * @param CampaignRole $campaignRole
     */
    public function deleted(CampaignRole $campaignRole)
    {
        CampaignCache::clearRoles()->clearAdmins();
    }

    /**
     * @param CampaignRole $campaignRole
     */
    public function updated(CampaignRole $campaignRole)
    {
        if ($campaignRole->is_admin) {
            CampaignCache::clearAdminRole()->clearAdmins();
        }
    }
}
