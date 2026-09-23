<?php

use App\Mail\MailgunTemplateMail;
use App\Models\User;
use App\Services\Emails\MailgunTemplateService;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\Email;

use function Pest\Laravel\mock;

it('uses the trigger name as the subject and sends template headers through Laravel Mail', function () {
    $user = User::factory()->make([
        'name' => 'Jane',
        'email' => 'jane@example.com',
    ]);
    $sentMessage = mock(SentMessage::class);
    $sentMessage->shouldReceive('getMessageId')->once()->andReturn('<mailgun-id>');

    expect((new MailgunTemplateMail(
        'welcome_2026',
        'Your campaign is ready',
        ['username' => 'Jane', 'link' => 'https://kanka.io/w/test'],
        'welcome',
    ))->render())->toContain('Mailgun template');

    $mailer = Mockery::mock();
    $mailer->shouldReceive('send')
        ->once()
        ->withArgs(function (MailgunTemplateMail $mail): bool {
            $envelope = $mail->envelope();
            $message = new Email;
            foreach ($envelope->using as $callback) {
                $callback($message);
            }

            return $envelope->subject === 'Your campaign is ready'
                && $message->getHeaders()->get('X-Mailgun-Template-Name')->getBodyAsString() === 'welcome_2026'
                && $message->getHeaders()->get('X-Mailgun-Template-Variables')->getBodyAsString() === json_encode([
                    'username' => 'Jane',
                    'link' => 'https://kanka.io/w/test',
                ])
                && $envelope->tags === ['welcome'];
        })
        ->andReturn($sentMessage);

    Mail::shouldReceive('to')
        ->once()
        ->with('jane@example.com')
        ->andReturn($mailer);

    expect(app(MailgunTemplateService::class)->send(
        $user,
        'welcome_2026',
        'Your campaign is ready',
        ['username' => 'Jane', 'link' => 'https://kanka.io/w/test'],
        'welcome',
    ))->toBe('<mailgun-id>');
});
