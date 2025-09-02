<?php

namespace App\Listeners\Campaigns;

use App\Events\Campaigns\Bragi\DisabledBragi;
use App\Jobs\BragiCleanupJob;

class CleanupBragi
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
    public function handle(DisabledBragi $event): void
    {
        BragiCleanupJob::dispatch($event->campaign->id);

        $event->user->campaignLog(
            $event->campaign->id,
            'bragi',
            'disabled',
        );
    }
}
