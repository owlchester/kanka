<?php

namespace App\Services\Campaign;

use App\Enums\UserAction;
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
        $this->user->log(UserAction::campaignDelete, ['campaign' => $this->campaign->id]);
        $this->campaign->delete();

        $this->campaignService->user($this->user)->next();
    }
}
