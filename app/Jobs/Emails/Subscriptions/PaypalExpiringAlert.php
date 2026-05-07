<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Enums\UserAction;
use App\Mail\Subscription\User\PaypalExpiringMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaypalExpiringAlert implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->id;
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
            ->send(new PaypalExpiringMail($user));

        $user->log(UserAction::subPaypalExpiringWarning);
    }
}
