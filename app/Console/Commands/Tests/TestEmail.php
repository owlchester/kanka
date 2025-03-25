<?php

namespace App\Console\Commands\Tests;

use App\Jobs\Emails\SubscriptionCancelEmailJob;
use App\Jobs\Emails\SubscriptionFailedEmailJob;
use App\Jobs\Emails\Subscriptions\ExpiringCardAlert;
use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Jobs\Emails\Subscriptions\WelcomeSubscriptionEmailJob;
use App\Jobs\Emails\WelcomeEmailJob;
use App\Models\Tier;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {user} {template=welcome}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $user = \App\Models\User::findOrFail($userId);

        $template = $this->argument('template');
        if ($template === 'welcome') {
            WelcomeEmailJob::dispatch($user, 'en');
        } elseif ($template === 'cancelled') {
            SubscriptionCancelEmailJob::dispatch($user, null, 'custom text');
        } elseif ($template === 'elemental') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'elemental')->first());
        } elseif ($template === 'wyvern') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'wyvern')->first());
        } elseif ($template === 'owlbear') {
            WelcomeSubscriptionEmailJob::dispatch($user, Tier::where('name', 'owlbear')->first());
        } elseif ($template === 'expiring') {
            ExpiringCardAlert::dispatch($user);
        } elseif ($template === 'failed') {
            SubscriptionFailedEmailJob::dispatch($user);
        } elseif ($template === 'upcoming') {
            UpcomingYearlyAlert::dispatch($user);
        } else {
            $this->warn('Unknown template ' . $template);
        }

        return 0;
    }
}
