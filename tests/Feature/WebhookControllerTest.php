<?php

use App\Enums\PricingPeriod;
use App\Http\Controllers\WebhookController;
use App\Jobs\Emails\Subscriptions\WelcomeSubscriptionEmailJob;
use App\Models\Pledge;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Queue;

function buildPayload(string $planId, string $customerId, string $status = 'active', array $previousAttributes = []): array
{
    return [
        'data' => [
            'object' => [
                'id' => 'sub_test123',
                'customer' => $customerId,
                'status' => $status,
                'cancel_at_period_end' => false,
                'plan' => ['id' => $planId],
                'items' => [
                    'data' => [
                        [
                            'id' => 'si_test123',
                            'price' => [
                                'id' => $planId,
                                'product' => 'prod_test',
                            ],
                            'quantity' => 1,
                        ],
                    ],
                ],
            ],
            'previous_attributes' => $previousAttributes,
        ],
    ];
}

function makeTierPrice(string $stripeId, string $tierName = Pledge::OWLBEAR): TierPrice
{
    $tier = Tier::factory()->create(['name' => $tierName]);

    return TierPrice::forceCreate([
        'tier_id' => $tier->id,
        'stripe_id' => $stripeId,
        'cost' => 4.99,
        'currency' => 'eur',
        'period' => PricingPeriod::Monthly,
    ]);
}

// handleCustomerSubscriptionCreated

it('sends emails for direct-to-active new subscriptions (CC without 3DS)', function () {
    $tierPrice = makeTierPrice('price_cc_new');
    $user = User::factory()->create(['stripe_id' => 'cus_cc_new', 'pledge' => null]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldReceive('user')->once()->andReturnSelf();
    $service->shouldReceive('plan')->once()->andReturnSelf();
    $service->shouldNotReceive('webhook');
    $service->shouldReceive('finish')->once()->andReturnSelf();

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionCreated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, status: 'active')
    );
});

it('skips emails for incomplete subscriptions on creation (PayPal/3DS pending)', function () {
    $tierPrice = makeTierPrice('price_paypal_created');
    $user = User::factory()->create(['stripe_id' => 'cus_paypal_created', 'pledge' => null]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldNotReceive('user');

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionCreated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, status: 'incomplete')
    );
});

// handleCustomerSubscriptionUpdated

it('sends emails when PayPal/3DS subscription activates (incomplete to active)', function () {
    $tierPrice = makeTierPrice('price_paypal_activate');
    $user = User::factory()->create(['stripe_id' => 'cus_paypal_activate', 'pledge' => null]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldReceive('user')->once()->andReturnSelf();
    $service->shouldReceive('plan')->once()->andReturnSelf();
    $service->shouldNotReceive('webhook');
    $service->shouldReceive('finish')->once()->andReturnSelf();

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionUpdated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, previousAttributes: ['status' => 'incomplete'])
    );
});

it('sends user welcome email on upgrade without notifying admin (pledge already updated by web controller)', function () {
    Queue::fake();

    $tierPrice = makeTierPrice('price_upgrade', Pledge::WYVERN);
    $user = User::factory()->create(['stripe_id' => 'cus_upgrade', 'pledge' => Pledge::WYVERN]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldReceive('user')->once()->andReturnSelf();
    $service->shouldReceive('plan')->once()->andReturnSelf();
    $service->shouldReceive('downgrading')->once()->andReturn(false);
    $service->shouldReceive('webhook')->once()->andReturnSelf();
    $service->shouldReceive('finish')->once()->andReturnSelf();

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionUpdated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, previousAttributes: ['plan' => ['id' => 'price_owlbear']])
    );

    Queue::assertPushed(WelcomeSubscriptionEmailJob::class);
});

it('suppresses emails on downgrade plan confirmation (downgrade email sent on request)', function () {
    $tierPrice = makeTierPrice('price_downgrade', Pledge::OWLBEAR);
    $user = User::factory()->create(['stripe_id' => 'cus_downgrade', 'pledge' => Pledge::WYVERN]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldReceive('user')->once()->andReturnSelf();
    $service->shouldReceive('plan')->once()->andReturnSelf();
    $service->shouldReceive('downgrading')->once()->andReturn(true);
    $service->shouldReceive('webhook')->once()->andReturnSelf();
    $service->shouldReceive('finish')->once()->andReturnSelf();

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionUpdated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, previousAttributes: ['plan' => ['id' => 'price_wyvern']])
    );
});

it('suppresses emails on renewal (no plan change, not a new activation)', function () {
    $tierPrice = makeTierPrice('price_renewal');
    $user = User::factory()->create(['stripe_id' => 'cus_renewal', 'pledge' => Pledge::OWLBEAR]);

    $service = $this->mock(SubscriptionService::class);
    $service->shouldReceive('user')->once()->andReturnSelf();
    $service->shouldReceive('plan')->once()->andReturnSelf();
    $service->shouldReceive('webhook')->once()->andReturnSelf();
    $service->shouldReceive('finish')->once()->andReturnSelf();

    app()->instance('App\Services\SubscriptionService', $service);

    $controller = app(WebhookController::class);
    $controller->handleCustomerSubscriptionUpdated(
        buildPayload($tierPrice->stripe_id, $user->stripe_id, previousAttributes: [])
    );
});
