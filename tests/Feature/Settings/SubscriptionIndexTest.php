<?php

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use Laravel\Cashier\Subscription;

it('defaults subscription pricing to yearly', function () {
    config(['services.stripe.enabled' => true]);
    $this->asUser();

    $this->get(route('settings.subscription'))
        ->assertOk()
        ->assertSee('text-neutral-content transition-all duration-150" data-period="monthly', false)
        ->assertSee('bg-base-100 flex items-center cursor-pointer justify-center gap-1 transition-all duration-150" data-period="yearly', false)
        ->assertSee('gap-4 period-year mx-auto lg:mx-0" id="pricing-overview', false);
});

it('shows the grandfathered price before the current standard price', function () {
    config(['services.stripe.enabled' => true]);

    $tier = Tier::factory()->create([
        'code' => 'owlbear',
        'name' => 'Owlbear',
    ]);
    $historical = TierPrice::factory()->inactive()->for($tier)->create([
        'currency' => 'usd',
        'period' => PricingPeriod::Monthly,
        'cost' => 4.99,
        'stripe_id' => 'price_old_owlbear',
    ]);
    TierPrice::factory()->for($tier)->create([
        'currency' => 'usd',
        'period' => PricingPeriod::Monthly,
        'cost' => 5.99,
        'stripe_id' => 'price_new_owlbear',
    ]);
    TierPrice::factory()->for($tier)->create([
        'currency' => 'usd',
        'period' => PricingPeriod::Yearly,
        'cost' => 59.99,
        'stripe_id' => 'price_new_owlbear_yearly',
    ]);
    $user = User::factory()->create(['settings' => ['currency' => 'usd'], 'pledge' => 'Owlbear']);
    Subscription::forceCreate([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_old_owlbear',
        'stripe_status' => 'active',
        'stripe_price' => $historical->stripe_id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('settings.subscription'))
        ->assertOk()
        ->assertSee('Grandfathered price')
        ->assertSee('Standard price: USD 5.99 billed monthly')
        ->assertSee('4.99', false);
});
