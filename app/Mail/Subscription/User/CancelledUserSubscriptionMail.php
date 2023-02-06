<?php

namespace App\Mail\Subscription\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelledUserSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

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
            ->from(['address' => config('app.email'), 'name' => 'Kanka Team'])
            ->subject('Confirmation: ' . $this->user->pledge . ' subscription cancellation')
            ->tag('cancelled')
            ->view('emails.subscriptions.cancelled.user-html');
    }
}
