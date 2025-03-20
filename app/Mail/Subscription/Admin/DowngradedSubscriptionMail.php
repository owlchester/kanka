<?php

namespace App\Mail\Subscription\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DowngradedSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    public $reason;

    public $custom;

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
            ->from(['address' => config('app.email'), 'name' => 'Kanka Admin'])
            ->subject('Subscription: Downgraded ' . $this->user->pledge)
            ->tag('admin-downgrade')
            ->view('emails.subscriptions.changed.html');
    }
}
