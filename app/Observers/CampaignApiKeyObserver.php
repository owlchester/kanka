<?php

namespace App\Observers;

use App\Events\Campaigns\Bragi\DisabledBragi;
use App\Models\CampaignApiKey;

class CampaignApiKeyObserver {

    public function deleted(CampaignApiKey $campaignApiKey)
    {
        DisabledBragi::dispatch($campaignApiKey->campaign, auth()->user());
    }
}
