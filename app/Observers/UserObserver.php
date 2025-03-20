<?php

namespace App\Observers;

use App\Facades\UserCache;
use App\Jobs\Emails\MailSettingsChangeJob;
use App\Jobs\Emails\WelcomeEmailJob;
use App\Jobs\Users\UnsubscribeUser;
use App\Jobs\Users\UpdateEmail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserObserver
{
    public function saving(User $user)
    {
        // Setting a new password
        $new = request()->post('password_new');
        if (! empty($new)) {
            $user->password = Hash::make(request()->post('password_new'));
        }

        // Purify the bio
        if (! empty($user->profile['bio'])) {
            $profile = $user->profile;
            try {
                $profile['bio'] = mb_substr(strip_tags($profile['bio']), 0, 301);
                $user->profile = $profile;
            } catch (Exception $e) {
                // An invalid profile, like emojis in text
                $profile['bio'] = '';
                $user->profile = $profile;
            }
        }

        // Purify Billing info
        if (! empty($user->profile['billing'])) {
            $profile = $user->profile;
            try {
                $profile['billing'] = mb_substr(strip_tags($profile['billing']), 0, 1024);
                $user->profile = $profile;
            } catch (Exception $e) {
                // invalid billing info, like emojis in text
                $profile['billing'] = '';
                $user->profile = $profile;
            }
        }
    }

    public function updated(User $user)
    {
        // Tell mailchimp about the user's new email
        if (! $user->wasRecentlyCreated && $user->isDirty('email') && $user->hasNewsletter()) {
            UpdateEmail::dispatch($user);
        }
        if ($user->isDirty('name')) {
            UserCache::user($user)->clearName();
        }
    }

    public function creating(User $user)
    {
        $user->locale = LaravelLocalization::getCurrentLocale();
        $settings = [];

        if (session()->has('tracking')) {
            $settings['tracking'] = session()->get('tracking');
            session()->remove('tracking');
        }

        if (session()->has('invite_token')) {
            $settings['invited'] = true;
        }

        if (count($settings) > 0) {
            $user->settings = $settings;
        }
    }

    public function created(User $user)
    {
        if (! app()->environment('testing')) {
            WelcomeEmailJob::dispatch($user, app()->getLocale());
        }
        session()->put('user_registered', true);

        if (request()->filled('newsletter')) {
            $user
                ->updateSettings(['mail_release' => 1])
                ->save();

            MailSettingsChangeJob::dispatch($user, true);
        }
    }

    /**
     * When a user is deleted, we need to clean up their avatar (only on production to avoid Jay doing silly things),
     * their newsletter status, cache, and later we also need to delete their stripe data after 3 months.
     */
    public function deleted(User $user)
    {
        // Log::info('Deleted user', ['user' => $user->id]);
        UserCache::user($user)
            ->clearName()
            ->clear();

        // If the user was subscribed to the newsletter, unsubscribe them
        if (app()->isProduction() && ! empty($user->hasNewsletter())) {
            UnsubscribeUser::dispatch($user->email);
        }
    }
}
