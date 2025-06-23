<?php

namespace App\Listeners\Campaigns\Roles;

use App\Events\Campaigns\Roles\RoleCreated;
use App\Events\Campaigns\Roles\RoleDeleted;
use App\Events\Campaigns\Roles\RoleUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRole
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
    public function handle(RoleCreated|RoleUpdated|RoleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof RoleCreated => 'created',
            $event instanceof RoleUpdated => 'updated',
            $event instanceof RoleDeleted => 'deleted',
        };

        $event->user->campaignLog(
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
