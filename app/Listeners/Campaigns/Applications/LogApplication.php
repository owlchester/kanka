<?php

namespace App\Listeners\Campaigns\Applications;

use App\Events\Campaigns\Applications\Accepted;
use App\Events\Campaigns\Applications\Rejected;

class LogApplication
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
    public function handle(Accepted|Rejected $event): void
    {
        $action = $event instanceof Accepted ? 'accepted' : 'rejected';
        $event->user->campaignLog(
            $event->campaign->id,
            'applications',
            $action, [
                'user' => $event->application->user->name,
                'id' => $event->application->user_id,
            ]
        );
    }
}
