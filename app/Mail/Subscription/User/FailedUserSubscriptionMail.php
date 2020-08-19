<?php

namespace App\Mail\Subscription\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FailedUserSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
            ->subject('Subscription: Failed ' . $this->user->patreon_pledge)
            ->view('emails.subscriptions.failed.user-html');
    }
}
