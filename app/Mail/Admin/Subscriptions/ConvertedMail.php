<?php

namespace App\Mail\Admin\Subscriptions;

use App\Enums\PricingPeriod;
use App\Enums\UserFlags;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConvertedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public PricingPeriod $period)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Sub: Converted ' . ucfirst($this->period->name) . ' ' . $this->user->pledge;

        return new Envelope(
            subject: $subject,
            tags: ['admin-new'],
            from: new Address(config('app.email'), 'Kanka Admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $trial = $this->user->flags()->where('flag', UserFlags::startTrial)->first();

        return new Content(
            markdown: 'emails.subscriptions.new.md',
            with: ['lastCancel' => null, 'user' => $this->user, 'period' => $this->period, 'trial' => $trial],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
