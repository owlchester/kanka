<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class MailgunTemplateMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected string $template,
        protected string $templateSubject,
        protected array $variables,
        protected string $tag,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.email'), 'Kanka.io'),
            subject: $this->templateSubject,
            tags: [$this->tag],
            using: function (Email $message): void {
                $headers = $message->getHeaders();
                $headers->addTextHeader('X-Mailgun-Template-Name', $this->template);
                $headers->addTextHeader('X-Mailgun-Template-Variables', json_encode($this->variables, JSON_THROW_ON_ERROR));
            },
        );
    }

    public function content(): Content
    {
        // Laravel requires a body even though Mailgun replaces it with its template.
        return new Content(htmlString: '<!-- Mailgun template -->');
    }
}
