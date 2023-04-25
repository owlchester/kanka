<?php

namespace App\Services\Campaign;

use App\Jobs\CampaignAssetExport;
use App\Jobs\CampaignExport;
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

        CampaignExport::dispatch($this->campaign, $this->user);
        CampaignAssetExport::dispatch($this->campaign, $this->user);

        return $this;
    }
}
