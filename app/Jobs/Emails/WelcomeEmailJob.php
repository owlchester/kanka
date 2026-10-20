<?php

namespace App\Jobs\Emails;

use App\Models\User;
use App\Services\Emails\OnboardingEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmailJob implements ShouldQueue
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $userId) {}

    public function handle(OnboardingEmailService $service): void
    {
        $user = User::find($this->userId);
        if ($user === null) {
            return;
        }

        $service->sendWelcome($user);
    }
}
