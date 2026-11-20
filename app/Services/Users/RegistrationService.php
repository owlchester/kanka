<?php

namespace App\Services\Users;

use App\Enums\ReferralEventType;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\WelcomeEmailJob;
use App\Models\User;
use App\Services\Referrals\JoinService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RegistrationService
{
    public function __construct(
        protected JoinService $referralService,
    ) {}

    /**
     * Register a new user from a web/OAuth request.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function register(array $attributes, bool $subscribeNewsletter = false): User
    {
        $settings = $attributes['settings'] ?? [];

        if (session()->has('tracking')) {
            $settings['tracking'] = session()->pull('tracking');
        }

        if (session()->has('invite_token')) {
            $settings['invited'] = true;
        }

        if ($subscribeNewsletter) {
            $settings['mail_release'] = 1;
        }

        $user = User::create([
            ...$attributes,
            'locale' => LaravelLocalization::getCurrentLocale(),
            'referred_by' => $this->referralService->referrer(),
            'settings' => $settings,
        ]);

        $this->referralService->event($user, ReferralEventType::register);

        if (! app()->environment('testing')) {
            WelcomeEmailJob::dispatch($user->id)
                ->delay(now()->addMinutes(1));
        }

        session()->put('user_registered', true);

        if ($subscribeNewsletter) {
            MailSettingsChangeJob::dispatch($user, true);
        }

        return $user;
    }
}
