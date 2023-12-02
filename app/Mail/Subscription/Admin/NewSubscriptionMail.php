<?php

namespace App\Mail\Subscription\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class NewSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

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
    public function __construct(User $user, string $period = 'monthly')
    {
        $this->user = $user;
        $this->period = $period;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $action = 'New';
        $lastCancel = $this->user->cancellations()->orderByDesc('id')->first();
        // Check if user was previously subbed

        // Auto-cancelled subs due to credit card issues don't trigger a cancellation, so we need to check previous
        // subs instead.
        $cancelled = Subscription::where('user_id', $this->user->id)->canceled()->count();
        if ($cancelled > 0) {
            $action = 'Renewed';
        }

        $subject = 'Subscription: ' . $action . ' ' . ucfirst($this->period) . ' ' . $this->user->pledge;
        return $this
            ->from(['address' => config('app.email'), 'name' => 'Kanka Admin'])
            ->subject($subject)
            ->tag('admin-new')
            ->view('emails.subscriptions.new.html', ["lastCancel" => $lastCancel]);
    }
}
