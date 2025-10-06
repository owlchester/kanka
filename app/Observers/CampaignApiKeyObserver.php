<?php

namespace App\Observers;

use App\Events\Campaigns\Bragi\DisabledBragi;
use App\Jobs\BragiFeedJob;
use App\Models\CampaignApiKey;

class CampaignApiKeyObserver {

    public function saved(CampaignApiKey $campaignApiKey)
    {
        //If enabling feed, if disabling delete embeds.
        if (!$campaignApiKey->getOriginal('is_enabled') && $campaignApiKey->is_enabled) {
            BragiFeedJob::dispatch($campaignApiKey->campaign_id);
        } elseif ($campaignApiKey->getOriginal('is_enabled') && !$campaignApiKey->is_enabled) {
            DisabledBragi::dispatch($campaignApiKey->campaign, auth()->user());
        }
    }

    public function deleted(CampaignApiKey $campaignApiKey)
    {
        DisabledBragi::dispatch($campaignApiKey->campaign, auth()->user());
    }
}
