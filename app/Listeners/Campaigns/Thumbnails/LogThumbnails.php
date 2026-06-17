<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailsDeleted;
use App\Facades\UserLogger;

class LogThumbnails
{
    public function handle(ThumbnailsDeleted $event): void
    {
        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'thumbnails',
            'deleted',
        );
    }
}
