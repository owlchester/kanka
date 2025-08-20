<?php

namespace App\Services\Campaign\ApiKeys;

use App\Models\CampaignApiKey;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class SaveService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    protected CampaignApiKey $apiKey;

    public function apiKey(CampaignApiKey $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function create(): void
    {
        $this->apiKey = new CampaignApiKey($this->request->all());
        $this->apiKey->campaign_id = $this->campaign->id;
        $this->apiKey->save();
    }
}
