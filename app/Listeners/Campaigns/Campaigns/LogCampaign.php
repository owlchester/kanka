<?php

namespace App\Listeners\Campaigns\Campaigns;

use App\Events\Campaigns\Updated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCampaign
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
    public function handle(Updated $event): void
    {
        if ($event->campaign->wasChanged('is_open')) {
            $event->user->campaignLog(
                $event->campaign->id,
                'applications',
                'switch',
                ['new' => $event->campaign->isOpen() ? 'open' : 'closed']
            );
        }
        if ($event->campaign->wasChanged('visibility_id')) {
            $event->user->campaignLog(
                $event->campaign->id,
                'visibility',
                'switch',
                ['new' => $event->campaign->isPublic() ? 'public' : 'private']
            );
        }
    }
}
