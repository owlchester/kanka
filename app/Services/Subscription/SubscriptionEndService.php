<?php

namespace App\Services\Subscription;

use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use Carbon\Carbon;

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
     * Find users with a pledge but no valid subscription and dispatch a cleanup job for each one
     *
     * @param  bool  $dispatch  set as false to not dispatch the job, just listing the expired subscriptions
     *                          in the admin job log.
     */
    public function run(bool $dispatch = true): int
    {
        $this->dispatch = $dispatch;

        $users = User::with(['boosts', 'boosts.campaign'])
            ->whereNotNull('pledge')
            ->where('pledge', '!=', '')
            ->where('settings', 'not like', '%patreon%')
            ->whereNull('banned_until')
            ->whereDoesntHave('subscriptions', function ($query) {
                $query->where('stripe_status', 'active')
                    ->orWhere('stripe_status', 'trialing')
                    ->orWhere('stripe_status', 'past_due')
                    ->orWhereDate('ends_at', '>=', Carbon::today()->toDateString());
            })
            ->get();

        foreach ($users as $user) {
            $this->process($user);
        }

        return $this->count;
    }

    protected function process(User $user): void
    {
        $this->logs[] = 'User ' . $user->name . ' (' . $user->id . ')';
        if ($this->dispatch) {
            SubscriptionEndJob::dispatch($user);
            $this->ids[] = $user->id;
        }
        $this->count++;
    }
}
