<?php

namespace App\Jobs\Emails;

use App\Mail\Subscription\User\FailedUserSubscriptionMail;
use App\Notifications\Header;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionFailedEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    public $userId;

    /**
     *
     */
    public $tries = 1;

    /**
     * WelcomeEmailJob constructor.
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
            Log::warning('Subscription Failed Email Job: unknown user id', ['userId' => $this->userId]);
            return;
        }

        $user->notify(new Header(
            'subscriptions.failed',
            'far fa-credit-card',
            'red'
        ));

        // Send an email to the admins
        /*Mail::to('hello@kanka.io')
            ->send(
                new FailedSubscriptionMail($user)
            );*/

        // Send an email to the user
        Mail::to($user->email)
            //->bcc('hello@kanka.io')
            ->send(
                new FailedUserSubscriptionMail($user)
            );
        $user->log(UserLog::TYPE_FAILED_CHARGE_EMAIL);
    }
}
