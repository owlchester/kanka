<?php

namespace App\Console\Commands\Emails;

use App\Jobs\Emails\SendOnboardingEmailJob;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;

class SendOnboardingEmails extends Command
{
    protected $signature = 'emails:onboarding';

    protected $description = 'Send scheduled onboarding emails';

    public function handle(): int
    {
        $now = now();
        $this->sendWindow($now->copy()->subHours(25), $now->copy()->subHours(24), 'day_one');
        $this->sendWindow($now->copy()->subHours(73), $now->copy()->subHours(72), 'day_three');

        return self::SUCCESS;
    }

    protected function sendWindow(
        CarbonInterface $from,
        CarbonInterface $to,
        string $stage,
    ): void {
        User::query()
            ->whereBetween('created_at', [$from, $to])
            ->chunkById(100, function ($users) use ($stage): void {
                foreach ($users as $user) {
                    SendOnboardingEmailJob::dispatch($user->id, $stage);
                }
            });
    }
}
