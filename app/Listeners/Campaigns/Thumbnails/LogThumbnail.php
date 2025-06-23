<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailCreated;
use App\Events\Campaigns\Thumbnails\ThumbnailDeleted;

class LogThumbnail
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
    public function handle(ThumbnailCreated|ThumbnailDeleted $event): void
    {
        $action = match (true) {
            $event instanceof ThumbnailCreated => 'created',
            $event instanceof ThumbnailDeleted => 'deleted',
        };

        $event->user->campaignLog(
            $event->campaign->id,
            'thumbnails',
            $action,
            [
                'type' => $event->entityType->code,
            ]
        );
    }
}
