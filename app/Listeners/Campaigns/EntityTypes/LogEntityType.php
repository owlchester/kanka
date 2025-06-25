<?php

namespace App\Listeners\Campaigns\EntityTypes;

use App\Events\Campaigns\EntityTypes\EntityTypeCreated;
use App\Events\Campaigns\EntityTypes\EntityTypeDeleted;
use App\Events\Campaigns\EntityTypes\EntityTypeToggled;
use App\Events\Campaigns\EntityTypes\EntityTypeUpdated;

class LogEntityType
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
    public function handle(EntityTypeCreated|EntityTypeUpdated|EntityTypeDeleted|EntityTypeToggled $event): void
    {
        $action = match (true) {
            $event instanceof EntityTypeCreated => 'created',
            $event instanceof EntityTypeUpdated => 'updated',
            $event instanceof EntityTypeDeleted => 'deleted',
            $event instanceof EntityTypeToggled => 'toggled',
        };

        if ($event instanceof EntityTypeUpdated && $event->entityType->wasChanged('is_enabled')) {
            $action = $event->entityType->is_enabled ? 'enabled' : 'disabled';
        } elseif ($event instanceof EntityTypeToggled) {
            $action = $event->campaign->setting->{$event->entityType->pluralCode()} ? 'enabled' : 'disabled';
        }

        $event->user->campaignLog(
            $event->entityType->campaign_id ?? $event->campaign->id,
            'entityTypes',
            $action,
            [
                'id' => $event->entityType->id,
                'code' => $event->entityType->code,
            ]
        );
    }
}
