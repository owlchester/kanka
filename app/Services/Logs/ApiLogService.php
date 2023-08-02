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

        ApiLog::create([
            'campaign_id' => $this->campaign?->id,
            'user_id' => auth()->user()->id,
            'uri' => request()->path(),
            'params' => request()->all()
        ]);
    }
}
