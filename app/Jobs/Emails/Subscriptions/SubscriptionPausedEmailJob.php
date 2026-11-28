<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Subscription\User\SubscriptionPausedMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionPausedEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $userId;

    protected int $resumeTimestamp;

    public function __construct(User $user, Carbon $resumeAt)
    {
        $this->userId = $user->id;
        $this->resumeTimestamp = $resumeAt->timestamp;
    }

    public function handle(): void
    {
        /** @var User|null $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        Mail::to($user->email)
            ->locale($user->locale)
            ->send(new SubscriptionPausedMail($user, Carbon::createFromTimestamp($this->resumeTimestamp)));
    }
}
