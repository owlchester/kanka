<?php

namespace App\Mail\Subscription\User;

use App\Models\Tier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.email'), 'Kanka Team'),
            subject: 'Thank you, and welcome!',
            tags: ['elemental']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.new.' . $this->tier->code,
        );
    }
}
