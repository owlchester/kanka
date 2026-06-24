<?php

namespace App\Listeners\Campaigns\Exports;

use App\Events\Campaigns\Exports\ExportCreated;
use App\Facades\UserLogger;

class LogExport
{
    public function handle(ExportCreated $event): void
    {
        UserLogger::user($event->user)->campaign(
            $event->campaignExport->campaign_id,
            'export',
            'queued'
        );
    }
}
