<?php

namespace App\Listeners\Campaigns\Roles;

use App\Events\Campaigns\Roles\RoleCreated;
use App\Events\Campaigns\Roles\RoleDeleted;
use App\Events\Campaigns\Roles\RoleUpdated;
use App\Facades\UserLogger;

class LogRole
{
    public function handle(RoleCreated|RoleUpdated|RoleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof RoleCreated => 'created',
            $event instanceof RoleUpdated => 'updated',
            $event instanceof RoleDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaignRole->campaign_id,
            'roles',
            $action,
            [
                'name' => $event->campaignRole->name,
                'id' => $event->campaignRole->id,
            ]
        );
    }
}
