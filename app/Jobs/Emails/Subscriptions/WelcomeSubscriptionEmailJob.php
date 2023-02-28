<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Subscription\User\NewSubscriberMail;
use App\User;
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

    /** @var int user id */
    public int $userId;

    /** @var string owlbear, wyvern or elemental */
    public string $tier;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     */
    public function __construct(User $user, string $tier = 'owlbear')
    {
        $this->userId = $user->id;
        $this->tier = $tier;
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

        // Send an email to the admins
        Mail::to($user->email)
            ->send(
                new NewSubscriberMail($user, $this->tier)
            );
    }
}
