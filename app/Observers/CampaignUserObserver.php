<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignFollower;
use App\Models\CampaignUser;

class CampaignUserObserver
{
    public function created(CampaignUser $campaignUser)
    {
        // When joining a campaign, stop following said campaign
        $follow = CampaignFollower::where('user_id', $campaignUser->user_id)
            ->where('campaign_id', $campaignUser->campaign_id)
            ->first();
        if ($follow) {
            $follow->delete();
        }

        // Update the campaign members cache when a user was added to the campaign
        CampaignCache::campaign($campaignUser->campaign)->clear();
    }

    public function deleted(CampaignUser $campaignUser)
    {
        // Update the campaign members cache when a user was deleted
        if ($campaignUser->campaign === null) {
            return;
        }
        CampaignCache::campaign($campaignUser->campaign)->clear();
    }
}
