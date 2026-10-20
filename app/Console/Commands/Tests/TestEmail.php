<?php

namespace App\Console\Commands\Tests;

use App\Events\FeatureCreated;
use App\Jobs\Emails\Purge\FirstWarningJob;
use App\Jobs\Emails\Purge\SecondWarningJob;
use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\Emails\SubscriptionDowngradedEmailJob;
use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Jobs\Emails\Subscriptions\WelcomeSubscriptionEmailJob;
use App\Jobs\Users\NewPassword;
use App\Models\Feature;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {user?} {template?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to a user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = $this->user();
        if ($user === null) {
            return self::FAILURE;
        }

        $template = $this->argument('template') ?: $this->choice('Email template', $this->templates());
        if ($template === 'welcome') {
            $this->error('Use test:onboarding-email for onboarding emails.');

            return self::FAILURE;
        } elseif ($template === 'cancelled') {
            SubscriptionCancelEmailJob::dispatch($user, null, 'custom text');
        } elseif ($template === 'downgrade') {
            SubscriptionDowngradedEmailJob::dispatch($user);
        } elseif ($template === 'elemental') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'elemental')->first());
        } elseif ($template === 'wyvern') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'wyvern')->first());
        } elseif ($template === 'owlbear') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'owlbear')->first());
        } elseif ($template === 'failed') {
            SubscriptionFailedEmailJob::dispatch($user);
        } elseif ($template === 'upcoming') {
            UpcomingYearlyAlert::dispatch($user);
        } elseif ($template === 'password') {
            NewPassword::dispatch($user);
        } elseif ($template === 'first') {
            FirstWarningJob::dispatch($user->id);
        } elseif ($template === 'second') {
            SecondWarningJob::dispatch($user->id);
        } elseif ($template === 'feature') {
            $feature = Feature::latest()->first();
            FeatureCreated::dispatch($feature);
        } else {
            $this->error('Unknown template ' . $template);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    protected function user(): ?User
    {
        $userId = $this->argument('user') ?: $this->ask('User ID');
        $user = User::find((int) $userId);

        if ($user === null) {
            $this->error("User [{$userId}] not found.");
        }

        return $user;
    }

    /**
     * @return list<string>
     */
    protected function templates(): array
    {
        return [
            'cancelled',
            'downgrade',
            'elemental',
            'wyvern',
            'owlbear',
            'failed',
            'upcoming',
            'password',
            'first',
            'second',
            'feature',
        ];
    }
}
