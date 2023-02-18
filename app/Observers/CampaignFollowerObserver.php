<?php

namespace App\Observers;

use App\Facades\SingleUserCache;
use App\Facades\UserCache;
use App\Models\CampaignFollower;

class CampaignFollowerObserver
{
    /**
     * @param CampaignFollower $campaignFollower
     */
    public function created(CampaignFollower $campaignFollower)
    {
        SingleUserCache::clearFollows();
        $campaignFollower->campaign->follower++;
        $campaignFollower->campaign->save();
    }

    /**
     * @param CampaignFollower $campaignFollower
     */
    public function deleted(CampaignFollower $campaignFollower)
    {
        SingleUserCache::clearFollows();
        $campaignFollower->campaign->follower--;
        $campaignFollower->campaign->save();
    }
}
