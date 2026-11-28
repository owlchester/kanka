<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PauseResumingMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $resumeDate;

    public function __construct(public User $user)
    {
        $pausedUntil = $user->subscription('kanka')?->getAttribute('paused_until');
        $this->resumeDate = $pausedUntil
            ? Carbon::parse((string) $pausedUntil)->isoFormat('MMMM D, Y')
            : '';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/pause-resuming.title'),
            tags: ['user', 'pause-resuming'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.pause-resuming.user',
        );
    }
}
