<?php

use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionService;
use Stripe\StripeClient;

it('redirects to subscription page when setup_intent is missing', function () {
    config(['services.stripe.enabled' => true]);

    $user = User::factory()->create();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', ['tier' => $tier]))
        ->assertRedirect(route('settings.subscription'));
});

it('redirects to subscription finish on successful setup intent', function () {
    config(['services.stripe.enabled' => true]);

    $user = User::factory()->create(['stripe_id' => 'cus_test123']);
    $tier = Tier::factory()->create();

    $setupIntentMock = new stdClass;
    $setupIntentMock->status = 'succeeded';
    $setupIntentMock->payment_method = 'pm_test123';

    $setupIntentsMock = Mockery::mock();
    $setupIntentsMock->shouldReceive('retrieve')
        ->with('seti_test123')
        ->andReturn($setupIntentMock);

    $stripeClientMock = new class($setupIntentsMock)
    {
        public function __construct(public mixed $setupIntents) {}
    };

    $this->app->bind(StripeClient::class, fn () => $stripeClientMock);

    $tierPriceMock = Mockery::mock(TierPrice::class)->makePartial();
    $tierPriceMock->id = 42;

    $subscriptionServiceMock = $this->mock(SubscriptionService::class);
    $subscriptionServiceMock->shouldReceive('user')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('tier')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('period')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('coupon')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('request')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('change')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('finish')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('subscriptionValue')->andReturn(500);
    $subscriptionServiceMock->shouldReceive('tierPrice')->andReturn($tierPriceMock);

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', [
            'tier' => $tier,
            'setup_intent' => 'seti_test123',
        ]))
        ->assertRedirect(route('settings.subscription.finish'));
});
