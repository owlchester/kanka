<?php

namespace App\Observers;

use App\Facades\CampaignCache;

/**
 * Class CampaignSettingObserver
 */
class CampaignSettingObserver
{
    public function saved()
    {
        CampaignCache::clear();
    }
}
