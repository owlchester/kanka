<?php

namespace App\Listeners;

use App\Campaign;
use App\Mail\UserRegistered;
use App\Models\UserLog;
use App\Services\CampaignService;
use App\Services\InviteService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Exception;

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
    public function onUserLogin($event)
    {
        // Does the user have a join campaign?
        if (Session::has('invite_token')) {
            try {
                $campaign = InviteService::useToken(Session::get('invite_token'));
                CampaignService::switchCampaign($campaign);
                return true;
            } catch (Exception $e) {
                // Silence errors here
            }
        }

        // Log the login
        if ($event->user) {
            $log = UserLog::create([
                'user_id' => $event->user->id,
                'action' => 'login',
                'ip' => request()->ip()
            ]);
            $log->save();
        }

        // We want to register in the session a campaign_id
        CampaignService::switchToNext();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        // Log the activity
        if ($event->user) {
            $log = UserLog::create([
                'user_id' => $event->user->id,
                'action' => 'logout',
                'ip' => request()->ip()
            ]);
            $log->save();
        }
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
