<?php

namespace App\Listeners\Campaigns\Plugins;

use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Facades\CampaignCache;

class ClearThemeCache
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
    public function handle(PluginUpdated|PluginDeleted $event): void
    {
        // If we changed the theme we'll need to re-think it
        if ($event->campaignPlugin->plugin->isTheme()) {
            CampaignCache::campaign($event->campaignPlugin->campaign)->clearTheme();
        }
    }
}
