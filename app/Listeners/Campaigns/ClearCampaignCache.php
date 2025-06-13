<?php

namespace App\Listeners\Campaigns;

use App\Facades\CampaignCache;

class ClearCampaignCache
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
    public function handle(object $event): void
    {
        $campaign = $event->campaignRoleUser->campaignRole->campaign
            ?? $event->campaign
            ?? null;

        CampaignCache::campaign($campaign)->clear();
    }
}
