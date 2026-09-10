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
    $subscriptionServiceMock->shouldReceive('request')->with([
        'payment_id' => 'pm_test123',
        'reason' => null,
        'reason_custom' => null,
    ])->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('change')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('downgrading')->andReturnFalse();
    $subscriptionServiceMock->shouldReceive('webhook')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('finish')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('subscriptionValue')->andReturn(500);
    $subscriptionServiceMock->shouldReceive('tierPrice')->andReturn($tierPriceMock);

    $response = $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', [
            'tier' => $tier,
            'setup_intent' => 'seti_test123',
        ]));

    $response
        ->assertRedirect(route('settings.subscription.finish'));
});

it('preserves downgrade feedback from a setup intent return', function () {
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
    $subscriptionServiceMock->shouldReceive('request')->with([
        'payment_id' => 'pm_test123',
        'reason' => 'financial',
        'reason_custom' => 'Too expensive',
    ])->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('change')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('downgrading')->andReturnFalse();
    $subscriptionServiceMock->shouldReceive('webhook')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('finish')->andReturnSelf();
    $subscriptionServiceMock->shouldReceive('subscriptionValue')->andReturn(500);
    $subscriptionServiceMock->shouldReceive('tierPrice')->andReturn($tierPriceMock);

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', [
            'tier' => $tier,
            'setup_intent' => 'seti_test123',
            'reason' => 'financial',
            'reason_custom' => 'Too expensive',
        ]))
        ->assertRedirect(route('settings.subscription.finish'));
});

it('redirects a successful secure payment callback to the subscription finish page', function () {
    config(['services.stripe.enabled' => true]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession([
            'subscription_callback' => 'pi_test123',
            'subscription_success' => true,
        ])
        ->get(route('settings.subscription.callback', ['success' => 1]))
        ->assertRedirect(route('settings.subscription.finish'));
});
