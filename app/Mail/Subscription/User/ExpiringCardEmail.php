<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringCardEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

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
            ->from(['address' => config('app.email'), 'name' => 'Kanka Team'])
            ->subject(__('emails/subscriptions/expiring.title'))
            ->view('emails.subscriptions.expiring.user-html')
            ->tag('expiring')
            ->text('emails.subscriptions.expiring.user-text');
    }
}
