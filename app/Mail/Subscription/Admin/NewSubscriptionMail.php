<?php

namespace App\Mail\Subscription\Admin;

use App\Enums\PricingPeriod;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;

class NewSubscriptionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public bool $new;

    public PricingPeriod $period;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, PricingPeriod $period)
    {
        $this->user = $user;
        $this->period = $period;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $action = 'New';
        // Check if user was previously subbed

        // Auto-cancelled subs due to credit card issues don't trigger a cancellation, so we need to check previous
        // subs instead.
        $cancelled = Subscription::where('user_id', $this->user->id)->canceled()->count();
        if ($cancelled > 0) {
            $action = 'Renewed';
        }

        $subject = 'Sub: ' . $action . ' ' . ucfirst($this->period->name) . ' ' . $this->user->pledge;

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
        $lastCancel = $this->user->cancellations()->orderByDesc('id')->first();

        return new Content(
            markdown: 'emails.subscriptions.new.md',
            with: ['lastCancel' => $lastCancel, 'user' => $this->user, 'period' => $this->period],
        );
    }
}
