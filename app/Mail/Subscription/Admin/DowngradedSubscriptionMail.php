<?php

namespace App\Mail\Subscription\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription: Downgraded ' . $this->user->pledge,
            tags: ['admin-downgrade'],
            from: new Address(config('app.email'), 'Kanka Admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.changed.md',
            with: ['user' => $this->user, 'reason' => $this->reason, 'custom' => $this->custom],
        );
    }
}
