<?php

namespace App\Mail\Subscription\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Subscription;

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
        $action = $this->new ? 'New' : 'Changed';
        // If new, check if user was previously subbed
        if ($this->new) {
            $cancelled = Subscription::where('user_id', $this->user->id)->cancelled()->count();
            if ($cancelled > 0) {
                $action = 'Renewed';
            }
        }

        $subject = 'Subscription: ' . $action . ' ' . ucfirst($this->period) . ' ' . $this->user->patreon_pledge;
        return $this
            ->from(['address' => 'no-reply@kanka.io', 'name' => 'Kanka Admin'])
            ->subject($subject)
            ->view('emails.subscriptions.' . ($this->new ? 'new' : 'changed') . '.html');
    }
}
