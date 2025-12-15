<?php

namespace App\Services\Subscription;

use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

class SubscriptionEndService
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

        $this->endSoforts();
        $this->endManuals();
        $this->endPaypals();

        return $this->count;
    }

    protected function endSoforts(): void
    {
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where(function ($sub) {
                $sub->where('stripe_id', 'like', 'sofort_%')
                    ->orWhere('stripe_id', 'like', 'giropay_%');
            })
            ->where('stripe_status', 'active')
            ->whereDate('ends_at', '<', Carbon::today()->toDateString())
            ->get();
        if ($subscriptions->count() === 0) {
            return;
        }
        $this->logs[] = 'Sofort';
        foreach ($subscriptions as $subscription) {
            $this->process($subscription);
        }
    }

    protected function endManuals(): void
    {
        // Now do the same thing for manual subs which ended on the current day, as manual subs end at midnight server time
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'manual_sub%')
            ->where('stripe_status', 'canceled')
            ->whereNotLike('stripe_price', 'trial_%')
            ->whereDate('ends_at', '=', Carbon::today()->subDays(4)->toDateString())
            ->get();
        if ($subscriptions->count() === 0) {
            return;
        }
        $this->logs[] = 'Manual';
        foreach ($subscriptions as $subscription) {
            $this->process($subscription);
        }
    }

    protected function endPaypals(): void
    {
        // Now do the same thing for manual subs which ended on the current day, as manual subs end at midnight server time
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'paypal_%')
            ->where('stripe_status', 'canceled')
            ->whereDate('ends_at', '=', Carbon::today()->toDateString())
            ->get();
        if ($subscriptions->count() === 0) {
            return;
        }
        $this->logs[] = 'Paypal';
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
            SubscriptionEndJob::dispatch($user);
            $subscription->stripe_status = 'canceled';
            $subscription->save();
            $this->ids[] = $user->id;
        }
        $this->count++;
    }
}
