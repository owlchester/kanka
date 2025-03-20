<?php

namespace App\Mail\Subscription\User;

use App\Models\Tier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubscriberMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public Tier $tier;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Tier $tier)
    {
        $this->user = $user;
        $this->tier = $tier;
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
            ->subject('Thank you, and welcome!')
            ->tag('elemental')
            ->view('emails.subscriptions.new.' . $this->tier->code);
    }
}
