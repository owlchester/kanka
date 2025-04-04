<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpiringCardEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    public $date;

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
        return new Envelope(
            subject: __('emails/subscriptions/expiring.title'),
            tags: ['expiring']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.expiring.user-md',
        );
    }
}
