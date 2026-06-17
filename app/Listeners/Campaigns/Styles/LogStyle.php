<?php

namespace App\Listeners\Campaigns\Styles;

use App\Events\Campaigns\Styles\StyleCreated;
use App\Events\Campaigns\Styles\StyleDeleted;
use App\Events\Campaigns\Styles\StyleUpdated;
use App\Facades\UserLogger;

class LogStyle
{
    public function handle(StyleCreated|StyleUpdated|StyleDeleted $event): void
    {
        $action = match (true) {
            $event instanceof StyleCreated => 'created',
            $event instanceof StyleUpdated => 'updated',
            $event instanceof StyleDeleted => 'deleted',
        };
        if ($event instanceof StyleUpdated && $event->campaignStyle->wasChanged('is_enabled')) {
            $action = $event->campaignStyle->is_enabled ? 'enabled' : 'disabled';
        }

        UserLogger::user($event->user)->campaign(
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
