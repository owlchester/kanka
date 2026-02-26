<?php

namespace App\Console\Commands;

use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;

class SubscriptionEndPaypalFix extends Command
{
    protected $signature = 'subscriptions:end-paypal-fix
                            {--dry-run : List affected users without dispatching jobs}';

    protected $description = 'One-time fix: dispatch SubscriptionEndJob for users with expired PayPal subs that still have an active pledge';

    public function handle(): int
    {
        $subscriptions = Subscription::with('user')
            ->where('stripe_price', 'like', 'paypal_%')
            ->where('stripe_status', 'canceled')
            ->where('ends_at', '<', now())
            ->whereHas('user', fn ($q) => $q->whereNotNull('pledge')->where('pledge', '<>', ''))
            ->whereNotExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('subscriptions as s2')
                    ->whereColumn('s2.user_id', 'subscriptions.user_id')
                    ->whereColumn('s2.id', '<>', 'subscriptions.id')
                    ->whereColumn('s2.created_at', '>', 'subscriptions.ends_at');
            })
            ->get();

        $count = $subscriptions->count();
        $this->info("Found {$count} affected users.");

        if ($count === 0) {
            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->table(
                ['User ID', 'Name', 'Email', 'Pledge', 'Ended At'],
                $subscriptions->map(fn (Subscription $sub) => [
                    $sub->user->id,
                    $sub->user->name,
                    $sub->user->email,
                    $sub->user->pledge,
                    $sub->ends_at,
                ])
            );

            return self::SUCCESS;
        }

        foreach ($subscriptions as $subscription) {
            /** @var User $user */
            $user = $subscription->user;
            SubscriptionEndJob::dispatch($user);
            $this->line("Dispatched for user {$user->id} ({$user->name})");
        }

        $this->info("Dispatched {$count} jobs.");

        return self::SUCCESS;
    }
}
