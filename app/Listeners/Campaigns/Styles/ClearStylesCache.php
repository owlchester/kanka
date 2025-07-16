<?php

namespace App\Listeners\Campaigns\Styles;

use App\Facades\CampaignCache;

class ClearStylesCache
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
        CampaignCache::campaign($event->campaign)->clearStyles();
    }
}
