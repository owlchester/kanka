<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Models\UserLog;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class UpcomingYearlyCommand extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alerts users of an upcoming yearly subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plans = array_merge(
            config('subscription.owlbear.yearly'),
            config('subscription.wyvern.yearly'),
            config('subscription.elemental.yearly'),
        );

        $now = Carbon::now()->addMonth();
        $log = "Looking for active yearly subscriptions created on month {$now->month} and day {$now->day}";
        $this->info($log);

        /**
         * We need to use updated_at and not created_at, because when a user switches from a monthly to a yearly
         * plan, it simply updated the subscription's plan_id to the new one. This might cause issues down the
         * line with other things that impact the updated_at field, so it might make more sense to track this
         * some other way in the future.
         */

        /** @var Subscription[] $subscriptions */
        $subscriptions = Subscription::whereIn('stripe_price', $plans)
            ->where('stripe_status', 'active')
            ->whereRaw('month(updated_at) = ' . $now->month)
            ->whereRaw('day(updated_at) = ' . $now->day)
            // ->whereRaw('year(created_at) <> ' . $now->year)
            ->whereNull('ends_at')
            ->with('user')
            ->get();

        $count = 0;
        foreach ($subscriptions as $subscription) {
            $userId = $subscription->user_id; // @phpstan-ignore-line
            $this->info('User #' . $userId . ' ' . $subscription->user->name); // @phpstan-ignore-line

            UpcomingYearlyAlert::dispatch($subscription->user); // @phpstan-ignore-line

            UserLog::create([
                'user_id' => $userId,
                'type_id' => UserLog::NOTIFY_YEARLY_SUB,
            ]);

            $count++;
        }

        $this->info('Notified ' . $count . ' users.');
        $log .= '<br />' . 'Notified ' . $count . ' users.';

        $this->log($log);

        return 0;
    }
}
