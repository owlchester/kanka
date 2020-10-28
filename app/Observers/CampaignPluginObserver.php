<?php

namespace App\Observers;

use App\Facades\CampaignCache;
use App\Models\CampaignPlugin;

class CampaignPluginObserver
{
    /**
     * Handle the models campaign plugin "created" event.
     *
     * @param  \App\Models\CampaignPlugin  $campaignPlugin
     * @return void
     */
    public function created(CampaignPlugin $campaignPlugin)
    {
        //
    }

    /**
     * Handle the models campaign plugin "updated" event.
     *
     * @param  \App\Models\CampaignPlugin  $campaignPlugin
     * @return void
     */
    public function updated(CampaignPlugin $campaignPlugin)
    {
        // If we changed the theme we'll need to re-think it
        if ($campaignPlugin->plugin->type() == 'theme') {
            CampaignCache::clearTheme();
        }

        $campaignPlugin->campaign->withObservers = false;
        $campaignPlugin->campaign->touch();
    }

    /**
     * Handle the models campaign plugin "deleted" event.
     *
     * @param  \App\Models\CampaignPlugin  $campaignPlugin
     * @return void
     */
    public function deleted(CampaignPlugin $campaignPlugin)
    {
        // Remove the theme from the campaign in case it was added
        if ($campaignPlugin->plugin->type() == 'theme') {
            CampaignCache::clearTheme();
        }
    }

    /**
     * Handle the models campaign plugin "restored" event.
     *
     * @param  \App\Models\CampaignPlugin  $campaignPlugin
     * @return void
     */
    public function restored(CampaignPlugin $campaignPlugin)
    {
        //
    }

    /**
     * Handle the models campaign plugin "force deleted" event.
     *
     * @param  \App\Models\CampaignPlugin  $campaignPlugin
     * @return void
     */
    public function forceDeleted(CampaignPlugin $campaignPlugin)
    {
        //
    }
}
