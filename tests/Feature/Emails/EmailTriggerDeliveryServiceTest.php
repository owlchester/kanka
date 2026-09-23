<?php

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger;
use App\Models\EmailTrigger as EmailTriggerModel;
use App\Models\EmailTriggerDelivery;
use App\Models\User;
use App\Services\Emails\EmailTriggerDeliveryService;
use App\Services\Emails\EmailTriggerRepository;
use App\Services\Emails\MailgunTemplateService;

use function Pest\Laravel\mock;

it('sends a configured trigger once per delivery stage', function () {
    $user = User::factory()->create();
    $configuration = new EmailTriggerModel;
    $configuration->id = 10;
    $configuration->name = 'One location. That\'s all you need.';
    $configuration->template = 'nudge_2026';

    $repository = mock(EmailTriggerRepository::class);
    $repository->shouldReceive('find')
        ->twice()
        ->with(EmailTrigger::Nudge, EmailAudience::Gm)
        ->andReturn($configuration);

    $mailgun = mock(MailgunTemplateService::class);
    $mailgun->shouldReceive('send')
        ->once()
        ->with($user, 'nudge_2026', 'One location. That\'s all you need.', ['username' => $user->name, 'link' => 'https://kanka.io/w/test'], 'nudge')
        ->andReturn('<message-id>');

    $service = new EmailTriggerDeliveryService($repository, $mailgun);

    expect($service->send($user, EmailTrigger::Nudge, EmailAudience::Gm, 'day_one', 'https://kanka.io/w/test'))
        ->toBeTrue();
    expect($service->send($user, EmailTrigger::Nudge, EmailAudience::Gm, 'day_one', 'https://kanka.io/w/test'))
        ->toBeFalse();

    $delivery = EmailTriggerDelivery::query()->firstOrFail();
    expect($delivery->status)->toBe(EmailTriggerDelivery::STATUS_SENT)
        ->and($delivery->attempts)->toBe(1)
        ->and($delivery->provider_message_id)->toBe('<message-id>');
});

it('records a failed provider send for a later retry', function () {
    $user = User::factory()->create();
    $configuration = new EmailTriggerModel;
    $configuration->id = 11;
    $configuration->name = 'Now give that character a place to live';
    $configuration->template = 'momentum_2026';

    $repository = mock(EmailTriggerRepository::class);
    $repository->shouldReceive('find')->andReturn($configuration);

    $mailgun = mock(MailgunTemplateService::class);
    $mailgun->shouldReceive('send')->once()->andThrow(new RuntimeException('Mailgun unavailable'));

    $service = new EmailTriggerDeliveryService($repository, $mailgun);

    expect(fn () => $service->send($user, EmailTrigger::Momentum, EmailAudience::Gm, 'day_one', 'https://kanka.io/w/test'))
        ->toThrow(RuntimeException::class, 'Mailgun unavailable');

    expect(EmailTriggerDelivery::query()->firstOrFail()->status)
        ->toBe(EmailTriggerDelivery::STATUS_FAILED);
});
