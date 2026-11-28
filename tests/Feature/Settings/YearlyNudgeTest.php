<?php

use App\Enums\PricingPeriod;
use App\Enums\UserFlags;
use App\Facades\UserCache;
use App\Jobs\Emails\Subscriptions\YearlyNudgeAlert;
use App\Models\Pledge;
use App\Models\Role;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Models\UserFlag;
use App\Models\Users\Tutorial;
use App\Services\Subscription\YearlyNudgeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Laravel\Cashier\Subscription;

function createNudgeSubscriber(int $daysActive = 75, bool $newsletter = true, string $period = 'monthly', float $monthlyCost = 4.99, float $yearlyCost = 49.90): array
{
    $role = Role::where('name', Pledge::ROLE)->first() ?? Role::forceCreate(['name' => Pledge::ROLE, 'display_name' => 'Subscriber']);
    $tier = Tier::firstWhere('code', 'owlbear') ?? Tier::factory()->create(['code' => 'owlbear', 'name' => 'Owlbear']);
    $monthly = TierPrice::factory()->for($tier)->create([
        'currency' => 'usd',
        'period' => PricingPeriod::Monthly,
        'cost' => $monthlyCost,
        'stripe_id' => 'price_nudge_m_' . uniqid(),
    ]);
    $yearly = TierPrice::factory()->for($tier)->create([
        'currency' => 'usd',
        'period' => PricingPeriod::Yearly,
        'cost' => $yearlyCost,
        'stripe_id' => 'price_nudge_y_' . uniqid(),
    ]);

    $user = User::factory()->create([
        'settings' => ['currency' => 'usd', 'mail_release' => $newsletter],
        'pledge' => Pledge::OWLBEAR,
    ]);
    $user->roles()->attach($role->id);

    $subscription = Subscription::forceCreate([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_' . uniqid(),
        'stripe_status' => 'active',
        'stripe_price' => $period === 'yearly' ? $yearly->stripe_id : $monthly->stripe_id,
        'quantity' => 1,
        'created_at' => Carbon::now()->subDays($daysActive),
        'updated_at' => Carbon::now()->subDays($daysActive),
    ]);

    return [$user, $subscription, $tier, $monthly, $yearly];
}

it('evaluates yearly nudge offer eligibility accurately', function () {
    // Eligible: monthly >= 60 days with positive savings
    [$user, $sub] = createNudgeSubscriber(daysActive: 75);
    $offer = app(YearlyNudgeService::class)->user($user)->offer();
    expect($offer)->not->toBeNull();
    expect($offer['savings'])->toBe(9.98);

    // Ineligible: < 60 days
    [$newUser] = createNudgeSubscriber(daysActive: 30);
    expect(app(YearlyNudgeService::class)->user($newUser)->offer())->toBeNull();

    // Ineligible: already yearly
    [$yearlyUser] = createNudgeSubscriber(daysActive: 75, period: 'yearly');
    expect(app(YearlyNudgeService::class)->user($yearlyUser)->offer())->toBeNull();

    // Ineligible: paused
    $sub->forceFill(['paused_until' => Carbon::now()->addMonth()])->save();
    expect(app(YearlyNudgeService::class)->user($user->fresh())->offer())->toBeNull();

    // Ineligible: grandfathered monthly where yearly does not save money
    [$grandfatheredUser] = createNudgeSubscriber(daysActive: 75, monthlyCost: 3.00, yearlyCost: 49.90);
    expect(app(YearlyNudgeService::class)->user($grandfatheredUser)->offer())->toBeNull();
});

it('shows the yearly nudge card on subscription page and banner only when eligible and not dismissed', function () {
    config(['services.stripe.enabled' => true]);

    [$user] = createNudgeSubscriber(daysActive: 75);

    $this->actingAs($user)
        ->get(route('settings.subscription'))
        ->assertOk()
        ->assertSee(__('subscriptions/yearly-nudge.card.title', ['savings' => 'US$9.98']))
        ->assertSee('banner_yearly_nudge');

    // Dismiss banner
    Tutorial::forceCreate(['user_id' => $user->id, 'code' => 'banner_yearly_nudge']);
    $freshUser = $user->fresh();
    UserCache::user($freshUser)->clear();

    $this->actingAs($freshUser)
        ->get(route('settings.subscription'))
        ->assertOk()
        ->assertDontSee('banner_yearly_nudge');
});

it('nudges eligible newsletter monthly subscribers once and respects limit', function () {
    Bus::fake();

    [$eligible1] = createNudgeSubscriber(daysActive: 75, newsletter: true);
    [$eligible2] = createNudgeSubscriber(daysActive: 90, newsletter: true);
    [$noNewsletter] = createNudgeSubscriber(daysActive: 90, newsletter: false);
    [$tooNew] = createNudgeSubscriber(daysActive: 15, newsletter: true);

    $this->artisan('subscriptions:nudge-yearly', ['--limit' => 1])
        ->assertExitCode(0);

    Bus::assertDispatchedTimes(YearlyNudgeAlert::class, 1);
    expect(UserFlag::where('flag', UserFlags::yearlyNudge->value)->count())->toBe(1);

    // Second run with higher limit nudges only the remaining eligible user
    $this->artisan('subscriptions:nudge-yearly', ['--limit' => 10])
        ->assertExitCode(0);

    Bus::assertDispatchedTimes(YearlyNudgeAlert::class, 2);
    expect($eligible1->flags()->where('flag', UserFlags::yearlyNudge->value)->exists())->toBeTrue();
    expect($eligible2->flags()->where('flag', UserFlags::yearlyNudge->value)->exists())->toBeTrue();
    expect($noNewsletter->flags()->where('flag', UserFlags::yearlyNudge->value)->exists())->toBeFalse();
    expect($tooNew->flags()->where('flag', UserFlags::yearlyNudge->value)->exists())->toBeFalse();
});
