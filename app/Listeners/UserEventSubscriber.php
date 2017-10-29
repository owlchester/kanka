<?php

namespace App\Listeners;

use App\Campaign;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        // We want to register in the session a campaign_id
        $campaign = Campaign::whereHas('users', function ($q) { $q->where('users.id', Auth::user()->id); })->first();
        if (!empty($campaign)) {
            Session::put('campaign_id', $campaign->id);
        }
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        // Do nothing
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}
