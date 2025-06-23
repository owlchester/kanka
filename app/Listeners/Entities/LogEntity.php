<?php

namespace App\Listeners\Entities;

use App\Events\Entities\EntityRestored;

class LogEntity
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
    public function handle(EntityRestored $event): void
    {
        $event->user?->campaignLog(
            $event->entity->campaign_id,
            'recovery',
            'entity',
            [
                'type' => $event->entity->entityType->code,
                'name' => $event->entity->name,
                'id' => $event->entity->id,
            ]
        );
    }
}
