<?php

namespace App\Services\Logs;

use App\Models\ApiLog;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class ApiLogService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    public function log()
    {
        if (! config('logging.enabled')) {
            return;
        }

        // Front-facing APIs? Don't log
        if (! isset($this->user)) {
            return;
        }

        ApiLog::create([
            'campaign_id' => isset($this->campaign) ? $this->campaign->id : null,
            'user_id' => $this->user->id,
            'uri' => $this->request->path(),
            'params' => $this->request->all(),
        ]);
    }
}
