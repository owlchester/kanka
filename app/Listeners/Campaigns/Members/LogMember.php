<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\UserJoined;
use App\Events\Campaigns\Members\UserLeft;

class LogMember
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
    public function handle(UserJoined|UserLeft $event): void
    {
        if ($event instanceof UserLeft) {
            $event->user->campaignLog(
                $event->campaign->id,
                'members',
                'left'
            );
        } else {
            $event->user->campaignLog(
                $event->campaign->id,
                'members',
                'joined',
                ['invite' => $event->campaignInvite->id]
            );
        }
    }
}
