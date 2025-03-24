<?php

namespace App\Mail\Subscription\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class CancelledSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public ?string $reason;

    public ?string $custom;

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
            with: ['user' => $this->user, 'reason' => $this->reason, 'custom' => $this->custom],
        );
    }
}