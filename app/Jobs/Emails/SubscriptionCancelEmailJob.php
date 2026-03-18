<?php

namespace App\Jobs\Emails;

use App\Enums\UserAction;
use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\User\CancelledUserSubscriptionMail;
use App\Models\SubscriptionCancellation;
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

    public int $cancellationId;

    /** @var int */
    public $tries = 3;

    public function __construct(SubscriptionCancellation $cancellation)
    {
        $this->cancellationId = $cancellation->id;
    }

    public function handle(): void
    {
        $cancellation = SubscriptionCancellation::find($this->cancellationId);
        if (empty($cancellation)) {
            return;
        }

        $user = $cancellation->user;
        if (empty($user)) {
            return;
        }

        // Send an email to the admins
        Mail::to('hello@kanka.io')
            ->send(new CancelledSubscriptionMail($cancellation));

        // Send an email to the user
        Mail::to($user->email)
            ->send(new CancelledUserSubscriptionMail($cancellation));

        $user->log(UserAction::subCancelManual);
    }
}
