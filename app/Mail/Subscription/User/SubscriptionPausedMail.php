<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionPausedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $resumeDate;

    public function __construct(public User $user, Carbon $resumeAt)
    {
        $this->resumeDate = $resumeAt->isoFormat('MMMM D, Y');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/paused.title'),
            tags: ['user', 'subscription-paused'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.paused.user',
        );
    }
}
