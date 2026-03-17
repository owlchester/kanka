<?php

namespace App\Mail\Subscription\Admin;

use App\Models\SubscriptionCancellation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelledSubscriptionMail extends Mailable
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
            subject: 'Sub: Cancelled ' . $this->user->pledge,
            tags: ['admin-cancelled'],
            from: new Address(config('app.email'), 'Kanka Admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.cancelled.md',
            with: ['cancellation' => $this->cancellation, 'user' => $this->user],
        );
    }
}
