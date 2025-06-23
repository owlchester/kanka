<?php

namespace App\Listeners\Campaigns\Exports;

use App\Events\Campaigns\Exports\ExportCreated;

class LogExport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExportCreated $event): void
    {
        $event->user->campaignLog(
            $event->campaignExport->campaign_id,
            'export',
            'queued'
        );
    }
}
