<?php

namespace App\Listeners\Campaigns\Admins;

use App\Events\Campaigns\Members\UserJoined;
use App\Events\Campaigns\Members\UserLeft;
use App\Services\Campaign\NotificationService;

class Notify
{
    /**
     * Create the event listener.
     */
    public function __construct(protected NotificationService $service)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserJoined|UserLeft $event): void
    {
        $key = 'join';
        $icon = 'user';
        $colour = 'success';
        $params = [];

        if ($event instanceof UserLeft) {
            $key = 'leave';
            $icon = 'user';
            $colour = 'warning';
            $params = [
                'user' => $event->user->name,
                'campaign' => $event->campaign->name,
                'link' => route('dashboard', $event->campaign),
            ];
        } elseif ($event instanceof UserJoined) {
            $params = [
                'user' => $event->user->name,
                'campaign' => $event->campaign->name,
                'link' => route('dashboard', $event->campaign),
            ];
        }
        $this->service
            ->campaign($event->campaign)
            ->notify($key, $icon, $colour, $params);
    }
}
