<?php

namespace App\Mail\Subscription\Admin;

use App\Models\Tier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DowngradedSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public ?string $reason;

    public ?string $custom;

    public ?Tier $newTier;

    public ?string $oldPledge;

    public function __construct(User $user, ?string $reason = null, ?string $custom = null, ?Tier $newTier = null, ?string $oldPledge = null)
    {
        $this->user = $user;
        $this->reason = $reason;
        $this->custom = $custom;
        $this->newTier = $newTier;
        $this->oldPledge = $oldPledge;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Subscription: Downgraded ' . ($this->oldPledge ?? $this->user->pledge);
        if ($this->newTier) {
            $subject .= ' → ' . $this->newTier->name;
        }

        return new Envelope(
            subject: $subject,
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
            with: ['user' => $this->user, 'reason' => $this->reason, 'custom' => $this->custom, 'newTier' => $this->newTier, 'oldPledge' => $this->oldPledge],
        );
    }
}
