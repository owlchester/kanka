<?php

namespace App\Services\Campaign;

use App\Jobs\Campaigns\Exports\Asset;
use App\Jobs\Campaigns\Exports\Entities;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class ExportService
{
    use CampaignAware;
    use UserAware;

    /**
     * Set the campaign export for the export jobs
     * @return $this
     */
    public function export(): self
    {
        $this->campaign->export_date = date('Y-m-d');
        $this->campaign->saveQuietly();

        Entities::dispatch($this->campaign, $this->user);
        Asset::dispatch($this->campaign, $this->user);

        return $this;
    }
}
