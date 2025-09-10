<?php

namespace App\Observers;

use App\Events\Campaigns\SettingsSaved;
use App\Facades\CampaignCache;
use App\Models\CampaignSetting;

/**
 * Class CampaignSettingObserver
 */
class CampaignSettingObserver
{
    public function saved(CampaignSetting $campaignSetting)
    {
        SettingsSaved::dispatch($campaignSetting->campaign, auth()->user());
    }
}
