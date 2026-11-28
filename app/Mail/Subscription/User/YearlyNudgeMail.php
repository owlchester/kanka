<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Number;

class YearlyNudgeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $savingsFormatted;

    public function __construct(
        public User $user,
        public string $tierName,
        float $savings,
        string $currencySymbol,
    ) {
        $this->savingsFormatted = $currencySymbol . Number::format($savings, 2);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/yearly-nudge.title', ['savings' => $this->savingsFormatted]),
            tags: ['user', 'yearly-nudge'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.yearly-nudge.user',
        );
    }
}
