<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelledUserSubscriptionMail extends Mailable
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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.email'), 'Kanka Team'),
            subject: 'Confirmation: ' . $this->user->pledge . ' subscription cancellation',
            tags: ['cancelled']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.cancelled.user-md',
        );
    }
}
