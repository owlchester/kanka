<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailCreated;
use App\Events\Campaigns\Thumbnails\ThumbnailDeleted;
use App\Facades\UserLogger;

class LogThumbnail
{
    public function handle(ThumbnailCreated|ThumbnailDeleted $event): void
    {
        $action = match (true) {
            $event instanceof ThumbnailCreated => 'created',
            $event instanceof ThumbnailDeleted => 'deleted',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'thumbnails',
            $action,
            [
                'type' => $event->entityType->code,
            ]
        );
    }
}
