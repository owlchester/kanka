<?php

namespace App\Services\Campaign\Exports;

use App\Enums\CampaignExportStatus;
use App\Jobs\Campaigns\Export;
use App\Models\CampaignExport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class QueueService
{
    use CampaignAware;
    use UserAware;

    public int $type = 1;

    public function queue()
    {
        $this->campaign->export_date = date('Y-m-d');
        $this->campaign->saveQuietly();

        $entitiesExport = CampaignExport::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->user->id,
            'type' => $this->type,
            'status' => CampaignExportStatus::scheduled,
        ]);

        Export::dispatch($this->campaign, $this->user, $entitiesExport)->onQueue('heavy');
    }

    public function type(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
