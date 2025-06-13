<?php

namespace App\Listeners\Campaigns;

use App\Facades\CampaignCache;

class ClearCampaignThemeCache
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
        $campaign = $event->campaignStyle->campaign
            ?? $event->campaign
            ?? null;

        CampaignCache::campaign($campaign)->clearTheme();
    }
}
