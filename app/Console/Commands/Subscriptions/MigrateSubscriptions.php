<?php

namespace App\Console\Commands\Subscriptions;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;

class MigrateSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update subscribers to the new sub pricing';

    protected int $count = 0;

    protected int $limit = 400;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $old = config('subscription.old.all');

        Subscription::with(['user', 'user.subscriptions', 'user.subscriptions.owner'])
            ->where('stripe_status', 'active')
            ->whereIn('stripe_price', $old)
            ->whereNotIn('user_id', [177165, 200759])
            ->has('user')
            ->chunkById(200, function ($subs) {
                if ($this->count > $this->limit) {
                    return false;
                }
                foreach ($subs as $s) {
                    if ($this->count > $this->limit) {
                        return false;
                    }
                    // Don't touch sofort people
                    if (Str::startsWith($s->stripe_id, 'sofort_')) {
                        continue;
                    }
                    $this->info('User #' . $s->user->id . ' ' . $s->user->email . ' https://dashboard.stripe.com/customers/' . $s->user->stripe_id);
                    try {
                        $old = $s->stripe_price;
                        $new = $this->map($old);
                        if ($new === 'error' || empty($new)) {
                            $this->error('Invalid old price ' . $old . ' to ' . $new);

                            continue;
                        }
                        $s->user->subscription('kanka')->noProrate()->swap($new);
                        $this->info('(' . $s->user->pledge . '): ' . $old . ' => ' . $new);
                    } catch (\Exception $e) {
                        $this->error($e->getMessage());
                    }
                    $this->count++;
                }
            });

    }

    protected function map(string $price): string
    {
        return match ($price) {
            config('subscription.old.oe') => config('subscription.owlbear.eur.monthly'),
            config('subscription.old.oey') => config('subscription.owlbear.eur.yearly'),
            config('subscription.old.ou') => config('subscription.owlbear.usd.monthly'),
            config('subscription.old.ouy') => config('subscription.owlbear.usd.yearly'),

            config('subscription.old.we') => config('subscription.wyvern.eur.monthly'),
            config('subscription.old.wey') => config('subscription.wyvern.eur.yearly'),
            config('subscription.old.wu') => config('subscription.wyvern.usd.monthly'),
            config('subscription.old.wuy') => config('subscription.wyvern.usd.yearly'),

            config('subscription.old.ee') => config('subscription.elemental.eur.monthly'),
            config('subscription.old.eey') => config('subscription.elemental.eur.yearly'),
            config('subscription.old.eu') => config('subscription.elemental.usd.monthly'),
            config('subscription.old.euy') => config('subscription.elemental.usd.yearly'),
            default => 'error',
        };
    }
}
