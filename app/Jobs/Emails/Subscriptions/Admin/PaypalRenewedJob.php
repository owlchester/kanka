<?php

namespace App\Jobs\Emails\Subscriptions\Admin;

use App\Mail\Subscription\Admin\PaypalRenewedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

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

        if (! Subscription::where('user_id', $user->id)->canceled()->exists()) {
            return;
        }

        Mail::to('hello@kanka.io')
            ->send(
                new PaypalRenewedMail($user)
            );
    }
}
