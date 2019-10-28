<?php

namespace App\Listeners;

use App\Models\UserLog;
use App\Services\CampaignService;
use App\Services\InviteService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Exception;

class UserEventSubscriber
{
    /**
     * @var InviteService
     */
    public $inviteService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(InviteService $inviteService)
    {
        $this->inviteService = $inviteService;
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        // Does the user have a join campaign?
        if (Session::has('invite_token')) {
            try {
                $campaign = $this->inviteService->useToken(Session::get('invite_token'));
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

            $event->user->update(['last_login_at' => Carbon::now()->toDateTimeString()]);
        }

        // We want to register in the session a campaign_id
        CampaignService::switchToLast($event->user);
        return true;
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
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
