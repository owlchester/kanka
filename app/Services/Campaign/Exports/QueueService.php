<?php

namespace App\Services\Campaign\Exports;

use App\Jobs\Campaigns\Export;
use App\Models\CampaignExport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class QueueService
{
    use CampaignAware;
    use UserAware;

    public function queue()
    {
        $this->campaign->export_date = date('Y-m-d');
        $this->campaign->saveQuietly();

        $entitiesExport = CampaignExport::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->user->id,
            'type' => 1,
            'status' => CampaignExport::STATUS_SCHEDULED,
        ]);

        Export::dispatch($this->campaign, $this->user, $entitiesExport)->onQueue('heavy');
    }
}
