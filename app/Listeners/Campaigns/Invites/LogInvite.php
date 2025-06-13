<?php

namespace App\Listeners\Campaigns\Invites;

use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogInvite
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
    public function handle(InviteCreated|InviteDeleted $event): void
    {
        $action = $event instanceof InviteCreated ? 'created' : 'deleted';
        $event->user->campaignLog(
            $event->campaignInvite->campaign_id,
            'invites',
            $action,
            [
                'id' => $event->campaignInvite->id
            ]
        );
    }
}
