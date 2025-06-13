<?php

namespace App\Listeners\Campaigns\Followers;

use App\Events\Campaigns\Followers\FollowerCreated;
use App\Events\Campaigns\Followers\FollowerRemoved;
use App\Facades\UserCache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateFollowerCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FollowerCreated|FollowerRemoved $event): void
    {
        $campaignFollower = $event->campaignFollower;

        UserCache::user($campaignFollower->user)->clear();

        if ($event instanceof FollowerCreated) {
            $campaignFollower->campaign->follower++;
        } else {
            $campaignFollower->campaign->follower--;
        }
        $campaignFollower->campaign->saveQuietly();
    }
}
