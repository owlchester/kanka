<?php

namespace App\Listeners\Campaigns\Members;

use App\Events\Campaigns\Members\RoleUserAdded;
use App\Events\Campaigns\Members\RoleUserRemoved;
use App\Jobs\CampaignRoleUserJob;

class RunRoleUserJob
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
        CampaignRoleUserJob::dispatch($event->campaignRoleUser, $event instanceof RoleUserAdded);
    }
}
