<?php

namespace App\Listeners;

use App\Models\UserLog;
use App\Services\CampaignService;
use App\Services\InviteService;
use App\Services\StarterService;
use App\User;
use Carbon\Carbon;
use Exception;

/**
 * @property User $user
 */
class UserEventSubscriber
{
    /** @var InviteService */
    public InviteService $inviteService;

    /** @var StarterService */
    public StarterService $starterService;

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
        $event->user->log($userLogType);
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
            // Todo: move this to the controller? Not sure why it should be an event's responsability
            // Let's create their first campaign for them
            $campaign = $this->starterService
                ->user($event->user)
                ->createCampaign();
            session()->remove('first_login');
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
        $event->user->log(UserLog::TYPE_LOGOUT);
    }

    /**
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
