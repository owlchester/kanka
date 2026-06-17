<?php

namespace App\Listeners\Campaigns\Invites;

use App\Events\Campaigns\Invites\InviteCreated;
use App\Events\Campaigns\Invites\InviteDeleted;
use App\Facades\UserLogger;

class LogInvite
{
    public function handle(InviteCreated|InviteDeleted $event): void
    {
        $action = $event instanceof InviteCreated ? 'created' : 'deleted';

        UserLogger::user($event->user)->campaign(
            $event->campaignInvite->campaign_id,
            'invites',
            $action,
            [
                'id' => $event->campaignInvite->id,
            ]
        );
    }
}
