<?php

namespace App\Mail\Subscription\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /** @var bool */
    public $new;

    /** @var string */
    public $period;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $period = 'monthly', bool $new = true)
    {
        $this->user = $user;
        $this->new = $new;
        $this->period = $period;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => 'no-reply@kanka.io', 'name' => 'Kanka Admin'])
            ->subject('Subscription: ' . ($this->new ? 'New' : 'Changed') . ' ' . ucfirst($this->period) . ' ' . $this->user->patreon_pledge)
            ->view('emails.subscriptions.' . ($this->new ? 'new' : 'changed') . '.html');
    }
}
