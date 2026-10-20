<?php

namespace App\Jobs\Emails;

use App\Models\User;
use App\Services\Emails\OnboardingEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOnboardingEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected int $userId,
        protected string $stage,
    ) {}

    public function handle(OnboardingEmailService $service): void
    {
        $user = User::find($this->userId);
        if ($user === null) {
            return;
        }

        match ($this->stage) {
            'day_one' => $service->sendDayOne($user),
            'day_three' => $service->sendDayThree($user),
            default => null,
        };
    }
}
