<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedUserSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

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
            ->from(['address' => config('app.email'), 'name' => 'Kanka Team'])
            ->subject('Warning: subscription issue')
            ->tag('failed')
            ->view('emails.subscriptions.charge-failed.user-html');
    }
}
