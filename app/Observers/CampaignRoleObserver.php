<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;

class CampaignRoleObserver
{
    /**
     * Created or updated role, clear the cache
     * @param CampaignRole $campaignRole
     */
    public function saved(CampaignRole $campaignRole)
    {
        if (CampaignLocalization::hasCampaign()) {
            CampaignCache::clearRoles()->clearAdmins();
        }
    }

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
