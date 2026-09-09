<?php

use App\Enums\PricingPeriod;
use App\Exceptions\UnknownTierPriceException;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Database\QueryException;
use Laravel\Cashier\Subscription;

it('uses only the active price for new subscriptions while retaining historical plans', function () {
    $tier = Tier::factory()->create();
    $historical = TierPrice::factory()->inactive()->for($tier)->create([
        'currency' => 'eur',
        'period' => PricingPeriod::Monthly,
        'cost' => 4.99,
        'stripe_id' => 'price_historical',
    ]);
    $active = TierPrice::factory()->for($tier)->create([
        'currency' => 'eur',
        'period' => PricingPeriod::Monthly,
        'cost' => 5.99,
        'stripe_id' => 'price_active',
        'pricing_version' => '2027',
    ]);
    $user = User::factory()->create(['settings' => ['currency' => 'eur']]);

    $tier->load('prices');
    $selected = (new SubscriptionService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->tierPrice();

    expect($selected->is($active))->toBeTrue()
        ->and($tier->price('eur', PricingPeriod::Monthly))->toBe(5.99)
        ->and($tier->monthlyPlans())->toContain($historical->stripe_id, $active->stripe_id);
});

it('resolves an inactive historical stripe price for webhooks', function () {
    $tier = Tier::factory()->create();
    $historical = TierPrice::factory()->inactive()->for($tier)->create([
        'stripe_id' => 'price_historical_webhook',
        'period' => PricingPeriod::Yearly,
    ]);

    $service = (new SubscriptionService)->plan($historical->stripe_id);
    $tierProperty = new ReflectionProperty($service, 'tier');
    $periodProperty = new ReflectionProperty($service, 'period');

    expect($tierProperty->getValue($service)->is($tier))->toBeTrue()
        ->and($periodProperty->getValue($service))->toBe(PricingPeriod::Yearly);
});

it('keeps an existing subscriber on their historical price', function () {
    $user = User::factory()->create();
    $historical = TierPrice::factory()->inactive()->create([
        'stripe_id' => 'price_grandfathered',
    ]);
    Subscription::forceCreate([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_grandfathered',
        'stripe_status' => 'active',
        'stripe_price' => $historical->stripe_id,
        'quantity' => 1,
    ]);

    $current = (new SubscriptionService)->user($user)->currentPlan();

    expect($current?->is($historical))->toBeTrue();
});

it('fails explicitly when stripe sends an unmapped price', function () {
    (new SubscriptionService)->plan('price_missing');
})->throws(UnknownTierPriceException::class, 'price_missing');

it('rejects duplicate stripe price ids', function () {
    $this->expectException(QueryException::class);

    TierPrice::factory()->create(['stripe_id' => 'price_duplicate']);

    TierPrice::factory()->create(['stripe_id' => 'price_duplicate']);
});
