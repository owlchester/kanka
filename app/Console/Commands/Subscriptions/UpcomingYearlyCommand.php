<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\UpcomingYearlyAlert;
use App\Models\UserLog;
use App\Models\JobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class UpcomingYearlyCommand extends Command
{
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
        $plans = [
            config('subscription.owlbear.eur.yearly'),
            config('subscription.owlbear.usd.yearly'),
            config('subscription.wyvern.eur.yearly'),
            config('subscription.wyvern.usd.yearly'),
            config('subscription.elemental.eur.yearly'),
            config('subscription.elemental.usd.yearly'),
        ];

        $now = Carbon::now()->addMonth();
        $log = "Looking for active yearly subscriptions created on month {$now->month} and day {$now->day}";
        $this->info($log);
        //$this->info('Plans: ' . implode('\', \'', $plans));

        /** @var Subscription[] $subscriptions */
        $subscriptions = Subscription::whereIn('stripe_plan', $plans)
            ->where('stripe_status', 'active')
            ->whereRaw('month(created_at) = ' . $now->month)
            ->whereRaw('day(created_at) = ' . $now->day)
            //->whereRaw('year(created_at) <> ' . $now->year)
            ->whereNull('ends_at')
            ->with('user')
            ->get()
        ;

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

        if (!config('app.log_jobs')) {
            return 0;
        }

        JobLog::create([
            'name' => $this->signature,
            'result' => $log,
        ]);

        return 0;
    }
}
