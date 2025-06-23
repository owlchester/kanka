<?php

namespace App\Observers;

use App\Events\Campaigns\Exports\ExportCreated;
use App\Models\CampaignExport;

class CampaignExportObserver
{
    public function created(CampaignExport $campaignExport)
    {
        ExportCreated::dispatch($campaignExport, auth()->user());
    }
}
