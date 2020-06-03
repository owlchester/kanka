<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignRole;

class CampaignRoleObserver
{
    /**
     * Created or updated role, clear the cache
     * @param CampaignRole $campaignRole
     */
    public function saved(CampaignRole $campaignRole)
    {
        CampaignCache::clearRoles();
    }

    /**
     * @param CampaignRole $campaignRole
     */
    public function deleted(CampaignRole $campaignRole)
    {
        CampaignCache::clearRoles();
    }
}
