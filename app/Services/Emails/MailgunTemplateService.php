<?php

namespace App\Services\Emails;

use App\Mail\MailgunTemplateMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class MailgunTemplateService
{
    /**
     * Send a Mailgun template using the subject configured on the trigger.
     */
    public function send(
        User $user,
        string $template,
        string $subject,
        array $variables,
        string $tag,
        ?string $recipient = null,
    ): string {
        $sentMessage = Mail::to($recipient ?? $user->email)
            ->send(new MailgunTemplateMail($template, $subject, $variables, $tag));

        $messageId = $sentMessage?->getMessageId();

        if (! is_string($messageId) || $messageId === '') {
            throw new RuntimeException('Mailgun did not return a message id.');
        }

        return $messageId;
    }
}
