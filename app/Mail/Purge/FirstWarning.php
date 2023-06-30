<?php

namespace App\Mail\Purge;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirstWarning extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    public mixed $campaigns;

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
            subject: __('emails/purge/first.title', ['amount' => config('purge.users.first.limit')]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.purge.first.html',
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
