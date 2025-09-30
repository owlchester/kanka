<?php

namespace App\Services\Subscription;

use App\Jobs\SubscriptionEndJob;
use App\Models\JobLog;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

class FreeTrialEndService
{
    protected int $count = 0;

    protected array $logs = [];

    protected bool $dispatch;

    /**
     * Find users with expired subscriptions and dispatch a cleanup job for each one
     *
     * @param  bool  $dispatch  set as false to not dispatch the job, just listing the expired subscriptions
     *                          in the admin job log.
     */
    public function run(bool $dispatch = true): int
    {
        $this->dispatch = $dispatch;

        $this->endFreeTrials();
        $this->log();

        return $this->count;
    }

    protected function endFreeTrials(): void
    {
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'manual_sub%')
            ->where('stripe_status', 'canceled')
            ->whereLike('stripe_price', 'trial_%')
            ->whereBetween('ends_at', [
                Carbon::now()->subMinute()->startOfMinute(),
                Carbon::now()->subMinute()->endOfMinute(),
            ])
            ->get();
        if ($subscriptions->count() === 0) {
            return;
        }
        $this->logs[] = 'Free trials';
        foreach ($subscriptions as $subscription) {
            $this->process($subscription);
        }
    }

    protected function process(Subscription $subscription): void
    {
        $this->logs[] = 'User ' . $subscription->user->name . ' (' . $subscription->user->id . '): ' . $subscription->ends_at;
        if ($this->dispatch) {
            SubscriptionEndJob::dispatch($subscription->user, false, true);
        }
        $this->count++;
    }

    /**
     * Save an job log for the admin interface
     *
     * @return void
     */
    protected function log()
    {
        if (! config('app.log_jobs')) {
            return;
        }

        JobLog::create([
            'name' => 'subscriptions:end-free-trials',
            'result' => implode("\n", $this->logs),
        ]);
    }
}
