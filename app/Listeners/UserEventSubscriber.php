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
    /** @var InviteService */
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
        if (session()->has('invite_token')) {
            try {
                $campaign = $this->inviteService->useToken(session()->get('invite_token'));
                CampaignService::switchCampaign($campaign);
                return true;
            } catch (Exception $e) {
                // Silence errors here
            }
        }

        // Log the login
        if ($event->user) {

            $ip = request()->ip();
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }
            $log = UserLog::create([
                'user_id' => $event->user->id,
                'type_id' => UserLog::TYPE_LOGIN,
                'ip' => $ip,
            ]);
            $log->save();

            // This triggers an "update" event directly
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
        if (!$event->user) {
            return;
        }

        $ip = request()->ip();
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        $log = UserLog::create([
            'user_id' => $event->user->id,
            'type_id' => UserLog::TYPE_LOGOUT,
            'ip' => $ip,
        ]);
        $log->save();
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
