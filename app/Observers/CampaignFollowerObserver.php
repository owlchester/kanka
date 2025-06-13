<?php

namespace App\Observers;

use App\Events\Campaigns\Followers\FollowerCreated;
use App\Events\Campaigns\Followers\FollowerRemoved;
use App\Facades\UserCache;
use App\Models\CampaignFollower;

class CampaignFollowerObserver
{
    public function created(CampaignFollower $campaignFollower)
    {
        FollowerCreated::dispatch($campaignFollower);
    }

    public function deleted(CampaignFollower $campaignFollower)
    {
        FollowerRemoved::dispatch($campaignFollower);
    }
}
