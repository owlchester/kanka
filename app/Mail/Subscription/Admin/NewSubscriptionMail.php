<?php

namespace App\Mail\Subscription\Admin;

use App\Enums\PricingPeriod;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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

    private function resolvePaymentMethod(): ?string
    {
        try {
            $pm = $this->user->defaultPaymentMethod();
            if (! $pm) {
                return null;
            }
            $stripePm = $pm->asStripePaymentMethod();
            if ($stripePm->type === 'card' && $stripePm->card) {
                return ucfirst($stripePm->card->brand);
            }
            if ($stripePm->type === 'paypal' && $stripePm->paypal) {
                return 'PayPal (' . ($stripePm->paypal->payer_email ?? 'unknown') . ')';
            }

            return ucfirst($stripePm->type);
        } catch (\Throwable $e) {
            Log::warning('Failed to retrieve payment method for sub email, user ' . $this->user->id . ': ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $lastCancel = $this->user->cancellations()->orderByDesc('id')->first();

        /** @var ?UserLog $log */
        $log = $this->user->logs()->whereNotNull('country')->latest()->first();

        $paymentMethod = $this->resolvePaymentMethod();

        return new Content(
            markdown: 'emails.subscriptions.new.md',
            with: ['lastCancel' => $lastCancel, 'user' => $this->user, 'period' => $this->period, 'trial' => false, 'country' => $log?->country, 'paymentMethod' => $paymentMethod],
        );
    }
}
