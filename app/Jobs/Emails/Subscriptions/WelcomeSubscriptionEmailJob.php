<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Subscription\User\NewSubscriberMail;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeSubscriptionEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $userId;

    public int $tierId;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     */
    public function __construct(User $user, Tier $tier)
    {
        $this->userId = $user->id;
        $this->tierId = $tier->id;
    }

    /**
     *
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        /** @var User|null $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        $tier = Tier::find($this->tierId);

        Mail::to($user->email)
            ->send(
                new NewSubscriberMail($user, $tier)
            );
    }
}
