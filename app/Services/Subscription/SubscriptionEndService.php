<?php

namespace App\Services\Subscription;

use App\Jobs\SubscriptionEndJob;
use App\Models\JobLog;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;

class SubscriptionEndService
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

        $this->logs[] = 'Sofort';
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where(function ($sub) {
                $sub->where('stripe_id', 'like', 'sofort_%')
                    ->orWhere('stripe_id', 'like', 'giropay_%');
            })
            ->where('stripe_status', 'active')
            ->whereDate('ends_at', '<', Carbon::today()->toDateString())
            ->get();
        $this->process($subscriptions);

        // Now do the same thing for manual subs which ended on the current day, as manual subs end at midnight server time
        $this->logs[] = 'Manual';
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'manual_sub%')
            ->where('stripe_status', 'canceled')
            ->whereDate('ends_at', '=', Carbon::today()->toDateString())
            ->get();
        $this->process($subscriptions);

        $this->log();

        return $this->count;
    }

    protected function process($subscriptions): void
    {
        foreach ($subscriptions as $sub) {
            $this->logs[] = 'User ' . $sub->user->name . ' (' . $sub->user->id . '): ' . $sub->ends_at;
            if ($this->dispatch) {
                SubscriptionEndJob::dispatch($sub->user);
                $sub->stripe_status = 'canceled';
                $sub->save();
            }
            $this->count++;
        }
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
            'name' => 'subscriptions:end',
            'result' => implode('<br />', $this->logs),
        ]);
    }
}
