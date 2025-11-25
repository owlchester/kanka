<?php

namespace App\Services\Subscription;

use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

class FreeTrialEndService
{
    protected int $count = 0;

    protected array $logs = [];

    protected bool $dispatch;

    protected array $ids = [];

    public function ids(): array
    {
        return $this->ids;
    }

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

        return $this->count;
    }

    protected function endFreeTrials(): void
    {
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'manual_sub%')
            ->where('stripe_status', 'canceled')
            ->whereLike('stripe_price', 'trial_%')
            ->whereDate('ends_at', '=', Carbon::now()->startOfDay())
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
        /** @var User $user */
        $user = $subscription->user;
        $this->logs[] = 'User ' . $user->name . ' (' . $user->id . '): ' . $subscription->ends_at;
        if ($this->dispatch) {
            $this->ids[] = $user->id;
            SubscriptionEndJob::dispatch($user, false, true);
        }
        $this->count++;
    }
}
