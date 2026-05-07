<?php

namespace App\Jobs\Emails\Subscriptions\Admin;

use App\Mail\Subscription\Admin\PaypalRenewedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class PaypalRenewedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->user);
        if (! $user) {
            return;
        }

        Mail::to('hello@kanka.io')
            ->send(
                new PaypalRenewedMail($user)
            );
    }
}
