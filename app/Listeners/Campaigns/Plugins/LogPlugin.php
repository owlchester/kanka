<?php

namespace App\Listeners\Campaigns\Plugins;

use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Events\Campaigns\Plugins\PluginUpdated;
use App\Facades\UserLogger;

class LogPlugin
{
    public function handle(PluginUpdated|PluginDeleted|PluginImported $event): void
    {
        $action = $event instanceof PluginUpdated ? 'updated' : 'deleted';
        if ($event instanceof PluginUpdated) {
            $action = 'updated';
            if ($event->campaignPlugin->wasChanged('is_active')) {
                $action = $event->campaignPlugin->is_active ? 'enabled' : 'disabled';
            }
            if ($event->campaignPlugin->wasChanged('plugin_version_id')) {
                $action = 'updated';
            }
        }
        if ($event instanceof PluginImported) {
            $action = 'imported';
        }

        UserLogger::user($event->user)->campaign(
            $event->campaignPlugin->campaign_id,
            'plugins',
            $action,
            [
                'name' => $event->campaignPlugin->plugin->name,
                'id' => $event->campaignPlugin->id,
                'plugin' => $event->campaignPlugin->plugin_id,
            ]
        );
    }
}
