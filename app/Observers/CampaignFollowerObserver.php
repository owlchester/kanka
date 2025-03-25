<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Models\CampaignFollower;

class CampaignFollowerObserver
{
    public function created(CampaignFollower $campaignFollower)
    {
        UserCache::clear();
        $campaignFollower->campaign->follower++;
        $campaignFollower->campaign->save();
    }

    public function deleted(CampaignFollower $campaignFollower)
    {
        UserCache::clear();
        $campaignFollower->campaign->follower--;
        $campaignFollower->campaign->save();
    }
}
