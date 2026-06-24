<?php

namespace App\Listeners\Campaigns\Dashboards;

use App\Events\Campaigns\Dashboards\DashboardCreated;
use App\Events\Campaigns\Dashboards\DashboardDeleted;
use App\Events\Campaigns\Dashboards\DashboardUpdated;
use App\Facades\UserLogger;

class LogDashboard
{
    public function handle(DashboardCreated|DashboardUpdated|DashboardDeleted $event): void
    {
        $action = match (true) {
            $event instanceof DashboardCreated => 'created',
            $event instanceof DashboardUpdated => 'updated',
            $event instanceof DashboardDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaignDashboard->campaign_id,
            'dashboards',
            $action,
            [
                'name' => $event->campaignDashboard->name,
                'id' => $event->campaignDashboard->id,
            ]
        );
    }
}
