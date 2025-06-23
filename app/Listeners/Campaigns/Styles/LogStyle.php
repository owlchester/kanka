<?php

namespace App\Listeners\Campaigns\Styles;

use App\Events\Campaigns\Styles\StyleDeleted;
use App\Events\Campaigns\Styles\StyleUpdated;

class LogStyle
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
    public function handle(ThumbnailCreated|StyleUpdated|StyleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof ThumbnailCreated => 'created',
            $event instanceof StyleUpdated => 'updated',
            $event instanceof StyleDeleted => 'deleted',
        };
        if ($event instanceof StyleUpdated && $event->campaignStyle->wasChanged('is_enabled')) {
            $action = $event->campaignStyle->is_enabled ? 'enabled' : 'disabled';
        }

        $event->user->campaignLog(
            $event->campaignStyle->campaign_id,
            'styles',
            $action,
            [
                'name' => $event->campaignStyle->name,
                'id' => $event->campaignStyle->id,
            ]
        );
    }
}
