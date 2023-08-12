<?php

namespace App\Services\Logs;

use App\Models\ApiLog;
use App\Traits\CampaignAware;

class ApiLogService
{
    use CampaignAware;

    public function log()
    {
        if (!config('logging.api')) {
            return;
        }

        // Front-facing APIs? Don't log
        if (auth()->guest()) {
            return;
        }

        ApiLog::create([
            'campaign_id' => isset($this->campaign) ? $this->campaign->id : null,
            'user_id' => auth()->user()->id,
            'uri' => request()->path(),
            'params' => request()->all()
        ]);
    }
}
