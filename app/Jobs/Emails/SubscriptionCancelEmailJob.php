<?php


namespace App\Jobs\Emails;


use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\User\CancelledUserSubscriptionMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionCancelEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    public $userId;

    /** @var string */
    public $reason;

    /** @var int */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     * @param User $user
     * @param string $reason
     */
    public function __construct(User $user, string $reason = null)
    {
        $this->userId = $user->id;
        $this->reason = $reason;
    }

    public function handle()
    {
        // User deleted their account already? Sure thing
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        // Send an email to the admins
        Mail::to('hello@kanka.io')
            ->send(
                new CancelledSubscriptionMail($user, $this->reason)
            );

        // Send an email to the user
        Mail::to($user->email)
            ->send(
                new CancelledUserSubscriptionMail($user, $this->reason)
            );
    }
}
