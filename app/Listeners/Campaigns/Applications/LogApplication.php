<?php

namespace App\Listeners\Campaigns\Applications;

use App\Events\Campaigns\Applications\Accepted;
use App\Events\Campaigns\Applications\Rejected;
use App\Facades\UserLogger;

class LogApplication
{
    public function handle(Accepted|Rejected $event): void
    {
        $action = $event instanceof Accepted ? 'accepted' : 'rejected';

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'applications',
            $action,
            [
                'user' => $event->application->user->name,
                'id' => $event->application->user_id,
            ]
        );
    }
}
