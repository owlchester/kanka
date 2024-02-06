<?php

namespace App\Console\Commands\Subscriptions;

use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $old = [
            env('STRIPE_OWLBEAR_EUR_OLD'),
            env('STRIPE_OWLBEAR_EUR_YEARLY_OLD'),
            env('STRIPE_OWLBEAR_USD_OLD'),
            env('STRIPE_OWLBEAR_USD_YEARLY_OLD'),
            env('STRIPE_WYVERN_EUR_OLD'),
            env('STRIPE_WYVERN_EUR_YEARLY_OLD'),
            env('STRIPE_WYVERN_USD_OLD'),
            env('STRIPE_WYVERN_USD_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_EUR_OLD'),
            env('STRIPE_ELEMENTAL_EUR_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_USD_OLD'),
            env('STRIPE_ELEMENTAL_USD_YEARLY_OLD'),
        ];

        Subscription::with(['user', 'user.subscriptions', 'user.subscriptions.owner'])
            ->where('stripe_status', 'active')
            ->whereIn('stripe_price', $old)
            ->chunkById(200, function ($subs) {
                foreach ($subs as $s) {
                    $this->info('User #' . $s->user->id . ' ' . $s->user->email);
                    try {
                        $old = $s->stripe_price;
                        $new = $this->map($old);
                        if ($new === 'error') {
                            $this->error('Invalid old price ' . $old);
                            continue;
                        }
                        $s->user->subscription('kanka')->noProrate()->swap($new);
                        $this->info('(' . $s->user->pledge . '): ' . $old . ' => ' . $new);
                    } catch (\Exception $e) {
                        $this->error($e->getMessage());
                    }
                }
            });

    }

    protected function map(string $price): string
    {
        return match($price) {
            env('STRIPE_OWLBEAR_EUR_OLD') => env('STRIPE_OWLBEAR_EUR'),
            env('STRIPE_OWLBEAR_EUR_YEARLY_OLD') => env('STRIPE_OWLBEAR_EUR_YEARLY'),
            env('STRIPE_OWLBEAR_USD_OLD') => env('STRIPE_OWLBEAR_USD'),
            env('STRIPE_OWLBEAR_USD_YEARLY_OLD') => env('STRIPE_OWLBEAR_USD_YEARLY'),

            env('STRIPE_WYVERN_EUR_OLD') => env('STRIPE_WYVERN_EUR'),
            env('STRIPE_WYVERN_EUR_YEARLY_OLD') => env('STRIPE_WYVERN_EUR_YEARLY'),
            env('STRIPE_WYVERN_USD_OLD') => env('STRIPE_WYVERN_USD'),
            env('STRIPE_WYVERN_USD_YEARLY_OLD') => env('STRIPE_WYVERN_USD_YEARLY'),

            env('STRIPE_ELEMENTAL_EUR_OLD') => env('STRIPE_ELEMENTAL_EUR'),
            env('STRIPE_ELEMENTAL_EUR_YEARLY_OLD') => env('STRIPE_ELEMENTAL_EUR_YEARLY'),
            env('STRIPE_ELEMENTAL_USD_OLD') => env('STRIPE_ELEMENTAL_USD'),
            env('STRIPE_ELEMENTAL_USD_YEARLY_OLD') => env('STRIPE_ELEMENTAL_USD_YEARLY'),
            default => 'error',
        };
    }
}
