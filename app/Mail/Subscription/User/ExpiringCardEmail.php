<?php

namespace App\Mail\Subscription\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringCardEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    public $date;

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
            ->subject(__('emails/subscriptions/expiring.title'))
            ->view('emails.subscriptions.expiring.user-html')
            ->text('emails.subscriptions.expiring.user-text');
    }
}
