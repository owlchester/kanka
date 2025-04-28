<?php

namespace App\Listeners;

use App\Jobs\Emails\MailSettingsChangeJob;
use App\Models\User;
use App\Models\UserLog;
use App\Services\Auth\LoginService;
use App\Services\Auth\SessionService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

/**
 * @property User $user
 */
class UserEventSubscriber
{
    public function __construct(
        protected LoginService $loginService,
        protected SessionService $sessionService,
    ) {}

    /**
     * Handle user login events.
     */
    public function handleUserLogin(Login $event): bool
    {
        /** @var User $user */
        $user = $event->user;
        // Log the user's login
        if (! $user) {
            Log::error('Missing user in login event');

            return false;
        }

        $this->loginService
            ->user($user)
            ->logUserActivity()
            ->updateLastLoginTime()
            ->clearInactivityFlag();

        // Update mailerlite for the login stuff
        if (! session()->has('first_login') && $user->hasNewsletter()) {
            MailSettingsChangeJob::dispatch($user);
        }

        // Process invite token or first login
        $inviteResult = $this->sessionService->user($user)->handleInviteToken();
        if ($inviteResult !== null) {
            return $inviteResult;
        }

        $firstLoginResult = $this->sessionService->user($user)->handleFirstLogin();
        if ($firstLoginResult !== null) {
            return $firstLoginResult;
        }

        return true;
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout(Logout $event)
    {
        // Log the activity
        if (! $event->user) {
            return;
        }
        if (! $event->user->isBanned()) {
            $event->user->log(UserLog::TYPE_LOGOUT);
        }
    }

    public function handleUserRegistered(Registered $event)
    {
        // If the user has an invite-token, we don't want to do anything else
        if (session()->has('invite_token')) {
            return;
        }

        session()->put('first_login', true);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleUserLogin',
            Logout::class => 'handleUserLogout',
            Registered::class => 'handleUserRegistered',
        ];
    }
}
