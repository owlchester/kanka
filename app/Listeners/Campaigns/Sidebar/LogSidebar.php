<?php

namespace App\Listeners\Campaigns\Sidebar;

use App\Events\Campaigns\Sidebar\SidebarReset;
use App\Events\Campaigns\Sidebar\SidebarSaved;

class LogSidebar
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
    public function handle(SidebarReset|SidebarSaved $event): void
    {
        if (! $event->campaign->wasChanged('ui_settings')) {
            return;
        }
        $action = match (true) {
            $event instanceof SidebarReset => 'reset',
            $event instanceof SidebarSaved => 'updated',
        };

        $event->user->campaignLog(
            $event->campaign->id,
            'sidebar',
            $action,
        );
    }
}
