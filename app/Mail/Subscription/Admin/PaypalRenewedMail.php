<?php

namespace App\Mail\Subscription\Admin;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaypalRenewedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

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
        $action = 'Renewed';

        $subject = 'Sub: ' . $action . ' Yearly ' . $this->user->pledge;

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
        $lastCancel = null;

        /** @var ?UserLog $log */
        $log = $this->user->logs()->whereNotNull('country')->latest()->first();

        return new Content(
            markdown: 'emails.subscriptions.new.md',
            with: ['lastCancel' => $lastCancel, 'user' => $this->user, 'period' => 'Yearly', 'trial' => false, 'country' => $log?->country],
        );
    }
}
