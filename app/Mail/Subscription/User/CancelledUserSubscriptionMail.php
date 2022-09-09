<?php

namespace App\Mail\Subscription\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelledUserSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $reason = null)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => 'hello@kanka.io', 'name' => 'Kanka Team'])
            ->subject('Subscription: Cancelled ' . $this->user->patreon_pledge)
            ->view('emails.subscriptions.cancelled.user-html');
    }
}
