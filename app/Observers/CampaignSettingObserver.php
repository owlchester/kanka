<?php


namespace App\Observers;


use App\Facades\CampaignCache;
use App\Models\CampaignSetting;

/**
 * Class CampaignSettingObserver
 * @package App\Observers
 */
class CampaignSettingObserver
{
    /**
     * @param CampaignSetting $campaignSetting
     */
    public function saved(CampaignSetting $campaignSetting)
    {
        CampaignCache::clearSettings();
    }
}
