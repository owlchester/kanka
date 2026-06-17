<?php

namespace App\Listeners\Campaigns\Sidebar;

use App\Events\Campaigns\Sidebar\SidebarReset;
use App\Events\Campaigns\Sidebar\SidebarSaved;
use App\Facades\UserLogger;

class LogSidebar
{
    public function handle(SidebarReset|SidebarSaved $event): void
    {
        if (! $event->campaign->wasChanged('ui_settings')) {
            return;
        }
        $action = match (true) {
            $event instanceof SidebarReset => 'reset',
            $event instanceof SidebarSaved => 'updated',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'sidebar',
            $action,
        );
    }
}
