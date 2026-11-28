<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Emails\Subscriptions\PauseResumingAlert;
use App\Models\User;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PauseResumingCommand extends Command
{
    use HasJobLog;

    protected $signature = 'subscriptions:pause-resuming';

    protected $description = 'Alert paused subscribers 3 days before billing resumes';

    protected int $count = 0;

    public function handle(): int
    {
        $target = Carbon::now()->addDays(3)->toDateString();
        $log = "Looking for paused subscriptions resuming on {$target}";
        $this->info($log);

        User::whereHas('subscriptions', function ($query) use ($target): void {
            $query->where('type', 'kanka')
                ->where('stripe_status', 'active')
                ->whereNull('ends_at')
                ->whereDate('paused_until', $target);
        })
            ->chunk(100, function ($users): void {
                foreach ($users as $user) {
                    $this->notify($user);
                }
            });

        $this->info('Alerted ' . $this->count . ' subscribers.');
        $log .= '<br />Alerted ' . $this->count . ' subscribers.';

        $this->log($log);

        return 0;
    }

    protected function notify(User $user): void
    {
        if (! $user->subscribed('kanka')) {
            return;
        }

        PauseResumingAlert::dispatch($user);
        $this->count++;
    }
}
