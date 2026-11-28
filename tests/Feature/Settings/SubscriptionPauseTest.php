<?php

use App\Enums\PricingPeriod;
use App\Enums\UserFlags;
use App\Http\Controllers\WebhookController;
use App\Jobs\Emails\Subscriptions\PauseResumingAlert;
use App\Jobs\Emails\Subscriptions\SubscriptionPausedEmailJob;
use App\Models\Pledge;
use App\Models\Role;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Models\UserFlag;
use App\Services\Subscription\PauseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Laravel\Cashier\Subscription;

function createMonthlySubscriber(int $daysActive = 45, string $currency = 'usd', float $cost = 4.99, float $yearlyCost = 49.90): array
{
    $role = Role::where('name', Pledge::ROLE)->first() ?? Role::forceCreate(['name' => Pledge::ROLE, 'display_name' => 'Subscriber']);
    $tier = Tier::firstWhere('code', 'owlbear') ?? Tier::factory()->create(['code' => 'owlbear', 'name' => 'Owlbear']);
    $monthly = TierPrice::factory()->for($tier)->create([
        'currency' => $currency,
        'period' => PricingPeriod::Monthly,
        'cost' => $cost,
        'stripe_id' => 'price_owl_m_' . uniqid(),
    ]);
    $yearly = TierPrice::factory()->for($tier)->create([
        'currency' => $currency,
        'period' => PricingPeriod::Yearly,
        'cost' => $yearlyCost,
        'stripe_id' => 'price_owl_y_' . uniqid(),
    ]);

    $user = User::factory()->create([
        'settings' => ['currency' => $currency],
        'pledge' => Pledge::OWLBEAR,
    ]);
    $user->roles()->attach($role->id);

    $subscription = Subscription::forceCreate([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_' . uniqid(),
        'stripe_status' => 'active',
        'stripe_price' => $monthly->stripe_id,
        'quantity' => 1,
        'created_at' => Carbon::now()->subDays($daysActive),
        'updated_at' => Carbon::now()->subDays($daysActive),
    ]);

    return [$user, $subscription, $tier, $monthly, $yearly];
}

it('evaluates pause eligibility accurately', function () {
    // Eligible: monthly >= 30 days
    [$user, $subscription, $tier, $monthly, $yearly] = createMonthlySubscriber(daysActive: 45);
    expect(app(PauseService::class)->user($user)->canPause())->toBeTrue();

    // Ineligible: < 30 days
    [$newUser] = createMonthlySubscriber(daysActive: 10);
    expect(app(PauseService::class)->user($newUser)->canPause())->toBeFalse();

    // Ineligible: yearly plan
    $subscription->forceFill(['stripe_price' => $yearly->stripe_id])->save();
    expect(app(PauseService::class)->user($user->fresh())->canPause())->toBeFalse();

    // Back to monthly, but already paused within 12 months
    $subscription->forceFill(['stripe_price' => $monthly->stripe_id])->save();
    UserFlag::forceCreate([
        'user_id' => $user->id,
        'flag' => UserFlags::subPaused->value,
        'created_at' => Carbon::now()->subMonths(3),
    ]);
    expect(app(PauseService::class)->user($user->fresh())->canPause())->toBeFalse();

    // Ineligible: grace period
    [$graceUser, $graceSub] = createMonthlySubscriber(daysActive: 45);
    $graceSub->forceFill(['ends_at' => Carbon::now()->addDays(10)])->save();
    expect(app(PauseService::class)->user($graceUser->fresh())->canPause())->toBeFalse();
});

it('pauses a subscription via controller, sets paused_until, flags user, and dispatches email', function () {
    config(['services.stripe.enabled' => true]);
    Bus::fake();

    [$user, $subscription] = createMonthlySubscriber(daysActive: 45);
    $periodEnd = Carbon::now()->addDays(12)->startOfHour();
    $expectedResume = $periodEnd->copy()->addMonthsNoOverflow(2)->subHour();

    $service = Mockery::mock(PauseService::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $service->shouldReceive('getStripePeriodEnd')->once()->andReturn($periodEnd->timestamp);
    $service->shouldReceive('updateStripePauseCollection')->once()->withArgs(function ($sub, $payload) use ($expectedResume) {
        return is_array($payload)
            && $payload['behavior'] === 'void'
            && $payload['resumes_at'] === $expectedResume->timestamp;
    });
    app()->instance(PauseService::class, $service);

    $this->actingAs($user)
        ->post(route('settings.subscription.pause'), ['months' => 2])
        ->assertRedirect(route('settings.subscription'))
        ->assertSessionHas('success');

    expect($subscription->fresh()->getAttribute('paused_until'))->not->toBeNull();
    expect(Carbon::parse((string) $subscription->fresh()->getAttribute('paused_until'))->timestamp)->toBe($expectedResume->timestamp);
    expect($user->flags()->where('flag', UserFlags::subPaused->value)->exists())->toBeTrue();
    Bus::assertDispatched(SubscriptionPausedEmailJob::class);
});

it('resumes a paused subscription via controller and clears paused_until', function () {
    config(['services.stripe.enabled' => true]);

    [$user, $subscription] = createMonthlySubscriber(daysActive: 45);
    $subscription->forceFill(['paused_until' => Carbon::now()->addMonth()])->save();

    $service = Mockery::mock(PauseService::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $service->shouldReceive('updateStripePauseCollection')->once()->withArgs(fn ($sub, $payload) => $payload === '');
    app()->instance(PauseService::class, $service);

    $this->actingAs($user)
        ->post(route('settings.subscription.resume'))
        ->assertRedirect(route('settings.subscription'))
        ->assertSessionHas('success');

    expect($subscription->fresh()->getAttribute('paused_until'))->toBeNull();
});

it('shows the pause option in the cancellation form only for eligible subscribers', function () {
    config(['services.stripe.enabled' => true]);

    [$user] = createMonthlySubscriber(daysActive: 45);
    $this->actingAs($user)
        ->get(route('settings.subscription.unsubscribe'))
        ->assertOk()
        ->assertSee(__('subscriptions/pause.cancel_modal.title'));

    [$newUser] = createMonthlySubscriber(daysActive: 5);
    $this->actingAs($newUser)
        ->get(route('settings.subscription.unsubscribe'))
        ->assertOk()
        ->assertDontSee(__('subscriptions/pause.cancel_modal.title'));
});

it('syncs paused_until on subscription updated webhook without sending upgrade emails', function () {
    Bus::fake();

    [$user, $subscription, $tier, $monthly] = createMonthlySubscriber(daysActive: 45);
    $user->stripe_id = 'cus_' . uniqid();
    $user->save();

    $resumeAt = Carbon::now()->addMonths(2)->startOfHour();
    $controller = app(WebhookController::class);

    $controller->handleCustomerSubscriptionUpdated([
        'data' => [
            'object' => [
                'id' => $subscription->stripe_id,
                'customer' => $user->stripe_id,
                'status' => 'active',
                'plan' => ['id' => $monthly->stripe_id],
                'items' => [
                    'data' => [
                        [
                            'id' => 'si_' . uniqid(),
                            'price' => ['id' => $monthly->stripe_id, 'product' => 'prod_1'],
                            'quantity' => 1,
                        ],
                    ],
                ],
                'pause_collection' => [
                    'behavior' => 'void',
                    'resumes_at' => $resumeAt->timestamp,
                ],
            ],
            'previous_attributes' => [
                'pause_collection' => null,
            ],
        ],
    ]);

    expect(Carbon::parse((string) $subscription->fresh()->getAttribute('paused_until'))->timestamp)->toBe($resumeAt->timestamp);

    $controller->handleCustomerSubscriptionUpdated([
        'data' => [
            'object' => [
                'id' => $subscription->stripe_id,
                'customer' => $user->stripe_id,
                'status' => 'active',
                'plan' => ['id' => $monthly->stripe_id],
                'items' => [
                    'data' => [
                        [
                            'id' => 'si_' . uniqid(),
                            'price' => ['id' => $monthly->stripe_id, 'product' => 'prod_1'],
                            'quantity' => 1,
                        ],
                    ],
                ],
                'pause_collection' => null,
            ],
            'previous_attributes' => [
                'pause_collection' => [
                    'behavior' => 'void',
                    'resumes_at' => $resumeAt->timestamp,
                ],
            ],
        ],
    ]);

    expect($subscription->fresh()->getAttribute('paused_until'))->toBeNull();
});

it('dispatches pause resuming alerts only for subscriptions resuming in 3 days', function () {
    Bus::fake();

    [$userIn3Days, $sub1] = createMonthlySubscriber(daysActive: 45);
    $sub1->forceFill(['paused_until' => Carbon::now()->addDays(3)])->save();

    [$userIn10Days, $sub2] = createMonthlySubscriber(daysActive: 45);
    $sub2->forceFill(['paused_until' => Carbon::now()->addDays(10)])->save();

    $this->artisan('subscriptions:pause-resuming')->assertExitCode(0);

    Bus::assertDispatchedTimes(PauseResumingAlert::class, 1);
});
