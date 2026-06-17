<?php

namespace App\Listeners\Entities;

use App\Events\Entities\EntityRestored;
use App\Facades\UserLogger;

class LogEntity
{
    public function handle(EntityRestored $event): void
    {
        if (! $event->user) {
            return;
        }

        UserLogger::user($event->user)->campaign(
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
