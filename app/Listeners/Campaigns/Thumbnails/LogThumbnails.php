<?php

namespace App\Listeners\Campaigns\Thumbnails;

use App\Events\Campaigns\Thumbnails\ThumbnailsDeleted;

class LogThumbnails
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
    public function handle(ThumbnailsDeleted $event): void
    {
        $event->user->campaignLog(
            $event->campaign->id,
            'thumbnails',
            'deleted',
        );
    }
}
