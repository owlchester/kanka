<?php

namespace App\Listeners;

use App\Models\UserFlag;
use App\Models\UserLog;
use App\Services\InviteService;
use App\Services\StarterService;
use App\Services\Users\CampaignService;
use App\Models\User;
use Carbon\Carbon;
use Exception;

/**
 * @property User $user
 */
class UserEventSubscriber
{
    protected InviteService $inviteService;

    protected StarterService $starterService;

    protected CampaignService $campaignService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        InviteService $inviteService,
        StarterService $starterService,
        CampaignService $campaignService
    ) {
        $this->inviteService = $inviteService;
        $this->starterService = $starterService;
        $this->campaignService = $campaignService;
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event): bool
    {
        // Log the user's login
        if (!$event->user) {
            dd('Error OSL-010');
        }

        $action = auth()->viaRemember() ? UserLog::TYPE_AUTOLOGIN : UserLog::TYPE_LOGIN;
        $userLogType = session()->get('kanka.userLog', $action);
        if ($event->user->isBanned()) {
            $userLogType = session()->get('kanka.userLog', UserLog::TYPE_BANNED_LOGIN);
        }
        $event->user->log($userLogType);

        session()->remove('kanka.userLog');
        $event->user->updateQuietly(['last_login_at' => Carbon::now()]);

        // Delete any flags to auto-delete the account based on inactivity
        UserFlag::where('user_id', $event->user->id)
            ->whereIn('flag', [UserFlag::FLAG_INACTIVE_1, UserFlag::FLAG_INACTIVE_2])
            ->delete();

        // Does the user have a join campaign token?
        if (session()->has('invite_token')) {
            try {
                $campaign = $this->inviteService
                    ->user($event->user)
                    ->useToken(session()->get('invite_token'));
                $this->campaignService
                    ->user($event->user)
                    ->campaign($campaign)
                    ->set();
                return true;
            } catch (Exception $e) {
                // Silence errors here
            }
        } elseif (session()->has('first_login')) {
            // Todo: move this to the controller? Not sure why it should be an event's responsibility
            // Let's create their first campaign for them
            $campaign = $this->starterService
                ->user($event->user)
                ->create();
            session()->remove('first_login');
            $this->campaignService
                ->user($event->user)
                ->campaign($campaign)
                ->set();
            return true;
        }

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
        if (!$event->user->isBanned()) {
            $event->user->log(UserLog::TYPE_LOGOUT);
        }
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
