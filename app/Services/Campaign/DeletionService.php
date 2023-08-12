<?php

namespace App\Services\Campaign;

use App\Models\UserLog;
use App\Services\CampaignService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class DeletionService
{
    use CampaignAware;
    use UserAware;

    public function delete(): void
    {
        $this->user->log(UserLog::TYPE_CAMPAIGN_DELETE);
        $this->campaign->delete();
        CampaignService::switchToNext();
    }
}
