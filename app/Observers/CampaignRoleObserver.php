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

    public function created(CampaignRole $campaignRole)
    {
        auth()->user()->campaignLog($campaignRole->campaign_id, 'roles', 'created', ['id' => $campaignRole->id]);
    }

    public function deleted(CampaignRole $campaignRole)
    {
        CampaignCache::clear();
        auth()->user()->campaignLog($campaignRole->campaign_id, 'roles', 'deleted', ['id' => $campaignRole->id]);
    }

    public function updated(CampaignRole $campaignRole)
    {
        if ($campaignRole->isAdmin()) {
            CampaignCache::clear();
        }
        auth()->user()->campaignLog($campaignRole->campaign_id, 'roles', 'updated', ['id' => $campaignRole->id]);
    }
}
