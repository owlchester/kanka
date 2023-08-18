<?php

namespace App\Observers;

use App\Facades\CampaignCache;

/**
 * Class CampaignSettingObserver
 * @package App\Observers
 */
class CampaignSettingObserver
{
    public function saved()
    {
        CampaignCache::clear();
    }
}
