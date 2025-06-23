<?php

namespace App\Listeners\Posts;

use App\Events\Posts\PostRestored;

class LogPost
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
    public function handle(PostRestored $event): void
    {
        $event->user?->campaignLog(
            $event->post->entity->campaign_id,
            'recovery',
            'post',
            [
                'name' => $event->post->name,
                'id' => $event->post->id,
            ]
        );
    }
}
