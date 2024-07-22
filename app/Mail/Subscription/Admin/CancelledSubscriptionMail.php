<?php

namespace App\Mail\Subscription\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelledSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public string|null $reason;
    public string|null $custom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ?string $reason = null, ?string $custom = null)
    {
        $this->user = $user;
        $this->reason = $reason;
        $this->custom = $custom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => config('app.email'), 'name' => 'Kanka Team'])
            ->subject('Sub: Cancelled ' . $this->user->pledge)
            ->tag('admin-cancelled')
            ->view('emails.subscriptions.cancelled.html');
    }
}
