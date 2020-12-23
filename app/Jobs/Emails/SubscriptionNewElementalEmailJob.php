<?php


namespace App\Jobs\Emails;


use App\Mail\Subscription\User\NewElementalSubscriptionMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionNewElementalEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int user id */
    public $userId;

    /** @var bool if new or changed */
    public $new;

    /** @var string yearly/monthly */
    public $period;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     * @param User $user
     * @param string $period
     * @param bool $new if it's a new sub or a changed sub
     */
    public function __construct(User $user, string $period = 'monthly', bool $new = true)
    {
        $this->userId = $user->id;
        $this->new = $new;
        $this->period = $period;
    }

    /**
     *
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        /** @var User $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        // Send an email to the admins
        Mail::to($user->email)
            ->send(
                new NewElementalSubscriptionMail($user, $this->period, $this->new)
            );
    }
}
