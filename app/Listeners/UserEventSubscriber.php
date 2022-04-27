<?php

namespace App\Listeners;

use App\Models\UserLog;
use App\Services\CampaignService;
use App\Services\InviteService;
use App\Services\StarterService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Exception;

/**
 * @property User $user
 */
class UserEventSubscriber
{
    /** @var InviteService */
    public $inviteService;

    /** @var StarterService */
    public $starterService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(InviteService $inviteService, StarterService $starterService)
    {
        $this->inviteService = $inviteService;
        $this->starterService = $starterService;
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        // Log the user's login
        if (!$event->user) {
            dd('Error OSL-010');
        }

        $default = UserLog::TYPE_LOGIN;
        if (auth()->viaRemember()) {
            $default = UserLog::TYPE_AUTOLOGIN;
        }
        $userLogType = session()->get('kanka.userLog', $default);
        $log = UserLog::create([
            'user_id' => $event->user->id,
            'type_id' => $userLogType,
        ]);
        $log->save();
        session()->remove('kanka.userLog');
        $event->user->update(['last_login_at' => Carbon::now()->toDateTimeString()]);

        // Does the user have a join campaign token?
        if (session()->has('invite_token')) {
            try {
                $campaign = $this->inviteService
                    ->user($event->user)
                    ->useToken(session()->get('invite_token'));
                CampaignService::switchCampaign($campaign);
                return true;
            } catch (Exception $e) {
                // Silence errors here
            }
        } elseif (session()->has('first_login')) {
            // Let's create their first campaign for them
            $campaign = $this->starterService
                ->user($event->user)
                ->createCampaign();
            CampaignService::switchCampaign($campaign);
            return true;
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

        $log = UserLog::create([
            'user_id' => $event->user->id,
            'type_id' => UserLog::TYPE_LOGOUT,
        ]);
        $log->save();
    }

    /**
     * @param $event
     */
    public function onUserRegistered($event)
    {
        // If the user has an invite token, we don't want to do anything else
        if (session()->has('invite_token')) {
            return;
        }

        session()->put('first_login', true);
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
            'Illuminate\Auth\Events\Registered',
            'App\Listeners\UserEventSubscriber@onUserRegistered'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}
