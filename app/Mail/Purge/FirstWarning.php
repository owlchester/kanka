<?php

namespace App\Mail\Purge;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirstWarning extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public mixed $campaigns;

    public $mailer = 'ses';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, mixed $campaigns)
    {
        $this->user = $user;
        $this->campaigns = $campaigns;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('hello@kanka.io', 'Kanka'),
            subject: __('emails/purge/first.title', ['amount' => config('purge.users.first.limit')]),
            tags: ['purge', 'first']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.purge.first.md',
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
