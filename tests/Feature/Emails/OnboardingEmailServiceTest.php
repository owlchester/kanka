<?php

use App\Enums\EmailAudience;
use App\Enums\EmailTrigger;
use App\Models\CampaignRole;
use App\Models\User;
use App\Services\Emails\EmailTriggerDeliveryService;
use App\Services\Emails\OnboardingEmailService;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\mock;

it('sends nudge to admins with no user-created entities', function () {
    $this->asUser()->withCampaign();
    $user = User::findOrFail(1);

    $delivery = mock(EmailTriggerDeliveryService::class);
    $delivery->shouldReceive('send')
        ->once()
        ->withArgs(function ($recipient, $trigger, $audience, $stage, $link) use ($user): bool {
            return $recipient->is($user)
                && $trigger === EmailTrigger::Nudge
                && $audience === EmailAudience::Gm
                && $stage === 'day_one'
                && str_contains($link, '/w/test-campaign');
        })
        ->andReturnTrue();

    expect((new OnboardingEmailService($delivery))->sendDayOne($user))->toBeTrue();
});

it('sends momentum when the user created a user-source entity', function () {
    $this->asUser()->withCampaign();
    $user = User::findOrFail(1);

    DB::table('entities')->insert([
        'name' => 'User entity',
        'entity_id' => 0,
        'campaign_id' => 1,
        'created_by' => $user->id,
        'source' => 'user',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $delivery = mock(EmailTriggerDeliveryService::class);
    $delivery->shouldReceive('send')
        ->once()
        ->withArgs(fn ($recipient, $trigger, $audience, $stage): bool => $recipient->is($user)
            && $trigger === EmailTrigger::Momentum
            && $audience === EmailAudience::Gm
            && $stage === 'day_one')
        ->andReturnTrue();

    expect((new OnboardingEmailService($delivery))->sendDayOne($user))->toBeTrue();
});

it('does not send day-one emails to campaign players', function () {
    $this->asUser()->withCampaign();
    $user = User::findOrFail(1);
    CampaignRole::query()->where('campaign_id', 1)->where('is_admin', true)->update(['is_admin' => false]);

    $delivery = mock(EmailTriggerDeliveryService::class);
    $delivery->shouldReceive('send')->never();

    expect((new OnboardingEmailService($delivery))->sendDayOne($user))->toBeFalse();
});
