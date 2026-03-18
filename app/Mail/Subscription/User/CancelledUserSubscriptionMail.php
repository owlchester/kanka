<?php

namespace App\Mail\Subscription\User;

use App\Models\SubscriptionCancellation;
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

    public SubscriptionCancellation $cancellation;

    public User $user;

    public function __construct(SubscriptionCancellation $cancellation)
    {
        $this->cancellation = $cancellation;
        $this->user = $cancellation->user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.email'), 'Kanka Team'),
            subject: 'Confirmation: ' . $this->cancellation->tier . ' subscription cancellation',
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
            with: ['cancellation' => $this->cancellation, 'user' => $this->user],
        );
    }
}
