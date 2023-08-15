<?php

namespace App\Services\Campaign;

use App\Models\UserLog;
use App\Services\Users\CampaignService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class DeletionService
{
    use CampaignAware;
    use UserAware;

    protected CampaignService $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function delete(): void
    {
        $this->user->log(UserLog::TYPE_CAMPAIGN_DELETE);
        $this->campaign->delete();

        $this->campaignService->user($this->user)->next();
    }
}
