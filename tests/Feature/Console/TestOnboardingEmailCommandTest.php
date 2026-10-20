<?php

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger as EmailTriggerEnum;
use App\Models\Campaign;
use App\Models\EmailTrigger as EmailTriggerModel;
use App\Models\User;
use App\Services\Emails\EmailTriggerRepository;
use App\Services\Emails\MailgunTemplateService;
use App\Services\Emails\OnboardingEmailService;
use Illuminate\Database\Eloquent\Collection;

use function Pest\Laravel\mock;

it('sends a selected inactive trigger to an email override', function () {
    $user = User::factory()->create(['name' => 'Test User']);
    $campaign = Campaign::factory()->make(['slug' => 'test-campaign']);
    $configuration = new EmailTriggerModel;
    $configuration->id = 5;
    $configuration->name = 'One location. That\'s all you need.';
    $configuration->trigger_id = EmailTriggerEnum::Nudge;
    $configuration->audience = EmailAudience::Gm;
    $configuration->cohort = null;
    $configuration->is_active = false;
    $configuration->template = 'nudge_2026';

    $repository = mock(EmailTriggerRepository::class);
    $repository->shouldReceive('all')->once()->andReturn(new Collection([$configuration]));

    $onboarding = mock(OnboardingEmailService::class);
    $onboarding->shouldReceive('campaignForAudience')
        ->once()
        ->withArgs(fn (User $recipient, EmailAudience $audience): bool => $recipient->is($user)
            && $audience === EmailAudience::Gm)
        ->andReturn($campaign);

    $mailgun = mock(MailgunTemplateService::class);
    $mailgun->shouldReceive('send')
        ->once()
        ->withArgs(function (
            User $recipient,
            string $template,
            string $subject,
            array $variables,
            string $tag,
            string $email,
        ) use ($user, $campaign): bool {
            return $recipient->is($user)
                && $template === 'nudge_2026'
                && $subject === 'One location. That\'s all you need.'
                && $variables === [
                    'username' => 'Test User',
                    'link' => route('dashboard', ['campaign' => $campaign]),
                ]
                && $tag === 'nudge'
                && $email === 'test@example.com';
        })
        ->andReturn('<message-id>');

    $this->artisan('test:onboarding-email', [
        'user' => $user->id,
        '--to' => 'test@example.com',
    ])
        ->expectsChoice(
            'Email configuration',
            '[inactive] #5 One location. That\'s all you need. | nudge / gm | cohort default',
            ['[inactive] #5 One location. That\'s all you need. | nudge / gm | cohort default'],
        )
        ->assertSuccessful();
});
