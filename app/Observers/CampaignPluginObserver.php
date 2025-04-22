<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignPlugin;

class CampaignPluginObserver
{
    /**
     * Handle the models campaign plugin "updated" event.
     *
     * @return void
     */
    public function updated(CampaignPlugin $campaignPlugin)
    {
        // If we changed the theme we'll need to re-think it
        if ($campaignPlugin->plugin->type() == 'theme') {
            CampaignCache::clearTheme();
        }

        $campaignPlugin->campaign->touchQuietly();
    }

    /**
     * Handle the models campaign plugin "deleted" event.
     *
     * @return void
     */
    public function deleted(CampaignPlugin $campaignPlugin)
    {
        // Remove the theme from the campaign in case it was added
        if ($campaignPlugin->plugin->type() == 'theme') {
            CampaignCache::clearTheme();
        }
    }
}
