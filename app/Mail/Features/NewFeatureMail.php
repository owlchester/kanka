<?php

namespace App\Mail\Features;

use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class NewFeatureMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Feature
     */
    public $feature;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New feature request',
            tags: ['admin-new-feature'],
            from: new Address(config('app.email'), 'Kanka Admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.features.md',
            with: ['feature' => $this->feature],
        );
    }
}
