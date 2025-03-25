<?php

namespace App\Services\Logs;

use App\Models\ApiLog;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;

class ApiLogService
{
    use CampaignAware;
    use RequestAware;

    public function log()
    {
        if (! config('logging.enabled')) {
            return;
        }

        // Front-facing APIs? Don't log
        if (auth()->guest()) {
            return;
        }

        ApiLog::create([
            'campaign_id' => isset($this->campaign) ? $this->campaign->id : null,
            'user_id' => auth()->user()->id,
            'uri' => $this->request->path(),
            'params' => $this->request->all(),
        ]);
    }
}
