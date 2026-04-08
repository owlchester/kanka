<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\PaypalExpiringAlert;
use App\Models\User;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaypalExpiringCommand extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:paypal-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert PayPal subscribers whose subscription expires in 14 days';

    /** @var int Number of alerts sent */
    protected int $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $target = Carbon::now()->addDays(14)->toDateString();
        $log = "Looking for PayPal subscriptions expiring on {$target}";
        $this->info($log);

        User::whereHas('subscriptions', function (\Illuminate\Database\Eloquent\Builder $query) use ($target): void {
            $query->where('stripe_price', 'like', 'paypal_%')
                ->whereDate('ends_at', $target);
        })
            ->chunk(100, function (\Illuminate\Support\Collection $users): void {
                foreach ($users as $user) {
                    $this->notify($user);
                }
            });

        $this->info('Alerted ' . $this->count . ' subscribers.');
        $log .= '<br />' . 'Alerted ' . $this->count . ' subscribers.';

        $this->log($log);

        return 0;
    }

    protected function notify(User $user): void
    {
        if (! $user->subscribed('kanka')) {
            return;
        }

        PaypalExpiringAlert::dispatch($user);
        $this->count++;
    }
}
