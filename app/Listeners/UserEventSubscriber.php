<?php

namespace App\Listeners;

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Models\User;
use App\Services\Auth\DeviceService;
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
        protected DeviceService $deviceService,
    ) {}

    /**
     * Handle user login events.
     */
    public function handleUserLogin(Login $event): bool
    {
        /** @var User $user */
        $user = $event->user;

        if (! $user) {
            Log::error('Missing user in login event');

            return false;
        }

        $this->loginService
            ->user($user)
            ->logUserActivity()
            ->updateLastLoginTime()
            ->clearInactivityFlag()
            ->loadFlags();

        try {
            $this->deviceService->findOrCreate($user);
        } catch (\Exception $e) {
            Log::error('Failed to create device record on login', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        if (! session()->has('first_login') && $user->hasNewsletter()) {
            MailSettingsChangeJob::dispatch($user);
        }

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
    public function handleUserLogout(Logout $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }
        if (! $event->user->isBanned()) {
            UserLogger::user($event->user)->log(UserAction::logout);
        }
    }

    public function handleUserRegistered(Registered $event): void
    {
        if (session()->has('invite_token')) {
            return;
        }

        session()->put('first_login', true);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Login::class,
            [UserEventSubscriber::class, 'handleUserLogin']
        );

        $events->listen(
            Logout::class,
            [UserEventSubscriber::class, 'handleUserLogout']
        );

        $events->listen(
            Registered::class,
            [UserEventSubscriber::class, 'handleUserRegistered']
        );
    }
}
