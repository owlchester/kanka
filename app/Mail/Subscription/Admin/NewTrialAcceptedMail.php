<?php

namespace App\Mail\Subscription\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class NewTrialAcceptedMail extends Mailable
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
        // Auto-cancelled subs due to credit card issues don't trigger a cancellation, so we need to check previous
        // subs instead.
        $cancelled = Subscription::where('user_id', $this->user->id)->canceled()->count();
        $action = 'New user accepted trial';
        if ($cancelled > 0) {
            $action = 'Former subscriber accepted trial';
        }

        $subject = 'Trial: ' . $action . ' ';

        return new Envelope(
            subject: $subject,
            tags: ['admin-trial-new'],
            from: new Address(config('app.email'), 'Kanka Admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $lastCancel = $this->user->cancellations()->orderByDesc('id')->first();

        return new Content(
            markdown: 'emails.subscriptions.trial.md',
            with: ['lastCancel' => $lastCancel, 'user' => $this->user],
        );
    }
}
