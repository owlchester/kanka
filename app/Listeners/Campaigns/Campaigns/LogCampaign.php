<?php

namespace App\Listeners\Campaigns\Campaigns;

use App\Events\Campaigns\Updated;
use App\Facades\UserLogger;

class LogCampaign
{
    public function handle(Updated $event): void
    {
        if ($event->campaign->wasChanged('is_open')) {
            UserLogger::user($event->user)->campaign(
                $event->campaign->id,
                'applications',
                'switch',
                ['new' => $event->campaign->isOpen() ? 'open' : 'closed']
            );
        }
        if ($event->campaign->wasChanged('visibility_id')) {
            UserLogger::user($event->user)->campaign(
                $event->campaign->id,
                'visibility',
                'switch',
                ['new' => $event->campaign->isPublic() ? 'public' : 'private']
            );
        }
    }
}
