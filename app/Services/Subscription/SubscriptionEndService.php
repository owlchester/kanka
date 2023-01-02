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

    /**
     * Find users with expired subscriptions and dispatch a cleanup job for each one
     * @param bool $dispatch set as false to not dispatch the job, just listing the expired subscriptions
     * in the admin job log.
     * @return int
     */
    public function run(bool $dispatch = true): int
    {
        $subscriptions = Subscription::with(['user', 'user.boosts', 'user.boosts.campaign'])
            ->where('stripe_id', 'like', 'sofort_%')
            ->where('stripe_status', 'active')
            ->whereDate('ends_at', '<', Carbon::today()->toDateString())
            ->get();
        foreach ($subscriptions as $sub) {
            $this->logs[] = 'User ' . $sub->user->name . ' (' . $sub->user->id . '): ' . $sub->ends_at;
            if ($dispatch) {
                SubscriptionEndJob::dispatch($sub->user);
                $sub->stripe_status = 'canceled';
                $sub->save();
            }
            $this->count++;
        }
        $this->log();
        return $this->count;
    }

    /**
     * Save an job log for the admin interface
     * @return void
     */
    protected function log()
    {
        if (!config('app.log_jobs')) {
            return;
        }

        JobLog::create([
            'name' => 'subscriptions:end',
            'result' => implode('<br />', $this->logs)
        ]);
    }
}
