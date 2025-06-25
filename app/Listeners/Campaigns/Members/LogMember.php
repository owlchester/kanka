<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\Switched;
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
    public function handle(UserJoined|UserLeft|Switched $event): void
    {
        $action = 'joined';
        $params = [];
        if ($event instanceof UserLeft) {
            $action = 'left';
        } elseif ($event instanceof Switched) {
            $action = 'switched';
            $params = ['to' => $event->campaignUser->user->name];
        } elseif ($event instanceof UserJoined) {
            $params = ['invite' => $event->campaignInvite->id];
        }
        $event->user->campaignLog(
            $event->campaign->id,
            'members',
            $action,
            $params,
        );
    }
}
