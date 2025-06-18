<?php

namespace App\Listeners\Campaigns;

use App\Events\Campaigns\Deleted;
use App\Events\Campaigns\Saved;
use App\Facades\UserCache;

class ClearCampaignUsersSaved
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
    public function handle(Saved|Deleted $event): void
    {
        // Whenever a campaign is changed, clear the cache for users and followers
        if ($event instanceof Deleted || $event->campaign->wasChanged(['visibility_id', 'name', 'image'])) {
            foreach ($event->campaign->users as $member) {
                UserCache::user($member)->clear();
            }

            foreach ($event->campaign->followers as $follower) {
                UserCache::user($follower)->clear();
            }
        }
    }
}
