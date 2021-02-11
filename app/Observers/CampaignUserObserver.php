<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignFollower;
use App\Models\CampaignUser;

class CampaignUserObserver
{
    /**
     * @param CampaignUser $campaignUser
     */
    public function saving(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function saved(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
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
        CampaignCache::campaign($campaignUser->campaign)->clearMembers();
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function creating(CampaignUser $campaignUser)
    {
    }

    /**
     * @param CampaignUser $campaignUser
     */
    public function deleted(CampaignUser $campaignUser)
    {
        // Update the campaign members cache when a user was deleted
        CampaignCache::campaign($campaignUser->campaign)->clearMembers();
    }
}
