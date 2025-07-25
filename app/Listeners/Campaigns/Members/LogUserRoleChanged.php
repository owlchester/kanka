<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;

class LogUserRoleChanged
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
    public function handle(RoleUserAdded|RoleUserRemoved $event): void
    {
        $action = $event instanceof RoleUserAdded ? 'created' : 'deleted';

        $event->user->campaignLog(
            $event->campaignRoleUser->campaignRole->campaign_id,
            'user-role',
            $action,
            [
                'user' => $event->campaignRoleUser->user->name,
                'user_id' => $event->campaignRoleUser->user_id,
                'role' => $event->campaignRoleUser->campaignRole->name,
                'role_id' => $event->campaignRoleUser->campaign_role_id,
            ]
        );
    }
}
