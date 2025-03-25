<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignRole;

class CampaignRoleObserver
{
    /**
     * Created or updated role, clear the cache
     */
    public function saved(CampaignRole $campaignRole)
    {
        CampaignCache::clear();
    }

    public function deleted(CampaignRole $campaignRole)
    {
        CampaignCache::clear();
    }

    public function updated(CampaignRole $campaignRole)
    {
        if ($campaignRole->isAdmin()) {
            CampaignCache::clear();
        }
    }
}
