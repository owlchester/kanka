<?php

namespace App\Console\Commands\Subscriptions;

use App\Enums\UserFlags;
use App\Jobs\Emails\Subscriptions\YearlyNudgeAlert;
use App\Models\User;
use App\Models\UserFlag;
use App\Services\Subscription\YearlyNudgeService;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NudgeYearlyCommand extends Command
{
    use HasJobLog;

    protected $signature = 'subscriptions:nudge-yearly {--limit=100}';

    protected $description = 'Send a one-time yearly upgrade nudge to eligible monthly subscribers';

    protected int $count = 0;

    public function handle(): int
    {
        $limit = max(1, (int) $this->option('limit'));
        $minDays = (app()->isProduction() || app()->runningUnitTests()) ? 60 : 0;
        $cutoff = Carbon::now()->subDays($minDays);
        $log = "Sending yearly upgrade nudges (limit {$limit})";
        $this->info($log);

        User::whereNull('banned_until')
            ->whereDoesntHave('flags', function ($query): void {
                $query->where('flag', UserFlags::yearlyNudge->value);
            })
            ->whereHas('subscriptions', function ($query) use ($minDays, $cutoff): void {
                $query->where('type', 'kanka')
                    ->where('stripe_status', 'active')
                    ->whereNull('ends_at')
                    ->whereNull('paused_until')
                    ->when($minDays > 0, fn ($sub) => $sub->where('created_at', '<=', $cutoff));
            })
            ->chunkById(100, function ($users) use ($limit): bool {
                foreach ($users as $user) {
                    if ($this->count >= $limit) {
                        return false;
                    }

                    $this->nudge($user);
                }

                return $this->count < $limit;
            });

        $this->info('Nudged ' . $this->count . ' subscribers.');
        $log .= '<br />Nudged ' . $this->count . ' subscribers.';

        $this->log($log);

        return 0;
    }

    protected function nudge(User $user): void
    {
        if (! $user->hasNewsletter()) {
            return;
        }

        $offer = app(YearlyNudgeService::class)->user($user)->offer();
        if ($offer === null) {
            return;
        }

        $flag = new UserFlag;
        $flag->user_id = $user->id;
        $flag->flag = UserFlags::yearlyNudge;
        $flag->save();

        YearlyNudgeAlert::dispatch($user);
        $this->count++;
    }
}
