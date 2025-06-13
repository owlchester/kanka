<?php

namespace App\Listeners\Users;

use App\Facades\UserCache;

class ClearUserCache
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
    public function handle(object $event): void
    {
        $user = $event->campaignRoleUser->user
            ?? $event->user
            ?? null;

        UserCache::user($user)->clear();
    }
}
