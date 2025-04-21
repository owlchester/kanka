<?php

namespace App\Jobs\Emails;

use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\User\CancelledUserSubscriptionMail;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionCancelEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $userId;

    /** @var string */
    public $reason;

    public $custom;

    /** @var int */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     */
    public function __construct(User $user, ?string $reason = null, ?string $custom = null)
    {
        $this->userId = $user->id;
        $this->reason = $reason;
        $this->custom = $custom;
    }

    public function handle()
    {
        // User deleted their account already? Sure thing
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        $reason = $this->reason;

        if ($reason == 'custom') {
            $reason = 'other';
        }
        // Send an email to the admins
        Mail::to('hello@kanka.io')
            ->send(
                new CancelledSubscriptionMail($user, $reason, $this->custom)
            );

        // Send an email to the user
        Mail::to($user->email)
            ->send(
                new CancelledUserSubscriptionMail($user)
            );
        $user->log(UserLog::TYPE_SUB_CANCEL_MANUAL);
    }
}
