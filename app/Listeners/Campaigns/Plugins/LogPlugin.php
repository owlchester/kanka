<?php

namespace App\Listeners\Campaigns\Plugins;

use App\Events\Campaigns\Plugins\PluginDeleted;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Events\Campaigns\Plugins\PluginUpdated;

class LogPlugin
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

        $event->user->campaignLog(
            $event->campaignPlugin->campaign_id,
            'plugins',
            $action,
            [
                'name' => $event->campaignPlugin->plugin->name,
                'id' => $event->campaignPlugin->id,
                'plugin' => $event->campaignPlugin->plugin_id,
            ]);
    }
}
