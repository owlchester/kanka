<?php


namespace App\Jobs\Emails;


use App\Mail\Subscription\Admin\DowngradedSubscriptionMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionDowngradedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int user id */
    public $userId;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     * @param User $user
     * @param bool $new if it's a new sub or a changed sub
     */
    public function __construct(User $user)
    {
        $this->userId = $user->id;
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
                new DowngradedSubscriptionMail($user)
            );
    }
}
