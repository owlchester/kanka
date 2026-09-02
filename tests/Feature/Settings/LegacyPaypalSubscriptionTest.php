<?php

use App\Enums\PricingPeriod;
use App\Exceptions\TranslatableException;
use App\Models\Tier;
use App\Models\User;
use App\Services\SubscriptionService;
use Laravel\Cashier\Subscription;

function createLegacyPaypalUser(): User
{
    $user = User::factory()->create(['pledge' => 'Elemental']);

    $subscription = new Subscription;
    $subscription->user_id = $user->id;
    $subscription->type = 'kanka';
    $subscription->stripe_id = 'paypal_test_' . uniqid();
    $subscription->stripe_status = 'canceled';
    $subscription->stripe_price = 'paypal_Elemental';
    $subscription->quantity = 1;
    $subscription->ends_at = now()->addMonth();
    $subscription->save();

    return $user;
}

it('shows legacy PayPal users why Stripe checkout is unavailable', function () {
    config(['services.stripe.enabled' => true]);

    $user = createLegacyPaypalUser();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.subscription.change', ['tier' => $tier]))
        ->assertViewIs('settings.subscription.change_blocked')
        ->assertSee('legacy PayPal system')
        ->assertSee('No data will be lost');
});

it('rejects direct subscription requests from legacy PayPal users', function () {
    config(['services.stripe.enabled' => true]);

    $user = createLegacyPaypalUser();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.subscription.subscribe', ['tier' => $tier]), [
            'payment_id' => 'pm_test123',
            'period' => 'monthly',
        ])
        ->assertRedirect(route('settings.subscription'))
        ->assertSessionHas('error_raw', fn (string $message): bool => str_contains($message, 'legacy PayPal system'));
});

it('rejects setup intent callbacks from legacy PayPal users', function () {
    config(['services.stripe.enabled' => true]);

    $user = createLegacyPaypalUser();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', [
            'tier' => $tier,
            'setup_intent' => 'seti_test123',
        ]))
        ->assertRedirect(route('settings.subscription'))
        ->assertSessionHas('error_raw', fn (string $message): bool => str_contains($message, 'legacy PayPal system'));
});

it('protects the subscription service from legacy PayPal users', function () {
    $user = createLegacyPaypalUser();
    $tier = Tier::factory()->create();

    $this->expectException(TranslatableException::class);

    (new SubscriptionService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->request(['payment_id' => 'pm_test123'])
        ->change();
});

it('does not consider an expired legacy PayPal subscription active', function () {
    $user = createLegacyPaypalUser();
    $user->subscription('kanka')->update(['ends_at' => now()->subMinute()]);

    expect($user->hasPayPal())->toBeFalse();
});
