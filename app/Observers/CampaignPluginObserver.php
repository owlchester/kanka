<?php

namespace App\Observers;

use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Models\CampaignPlugin;

class CampaignPluginObserver
{
    public function updated(CampaignPlugin $campaignPlugin)
    {
        PluginUpdated::dispatch($campaignPlugin, auth()->user());
    }

    public function deleted(CampaignPlugin $campaignPlugin)
    {
        PluginDeleted::dispatch($campaignPlugin, auth()->user());
    }
}
