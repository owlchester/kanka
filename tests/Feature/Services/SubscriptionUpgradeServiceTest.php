<?php

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionUpgradeService;
use Laravel\Cashier\Subscription;
use Stripe\StripeClient;
use Stripe\Util\Util;

it('only charges the proration for right now, not the following billing cycle, when previewing an upgrade', function () {
    config(['services.stripe.enabled' => true]);

    $user = User::factory()->create(['stripe_id' => 'cus_test123']);

    $subscription = new Subscription;
    $subscription->user_id = $user->id;
    $subscription->type = 'kanka';
    $subscription->stripe_id = 'sub_test123';
    $subscription->stripe_status = 'active';
    $subscription->stripe_price = 'price_old';
    $subscription->quantity = 1;
    $subscription->save();

    $tier = Tier::factory()->create();

    $tierPrice = new TierPrice;
    $tierPrice->tier_id = $tier->id;
    $tierPrice->currency = 'usd';
    $tierPrice->cost = 8.00;
    $tierPrice->period = PricingPeriod::Monthly;
    $tierPrice->stripe_id = 'price_new';
    $tierPrice->save();

    $stripeSubscription = Util::convertToStripeObject([
        'id' => 'sub_test123',
        'object' => 'subscription',
        'status' => 'active',
        'items' => [
            'object' => 'list',
            'has_more' => false,
            'data' => [[
                'id' => 'si_test123',
                'object' => 'subscription_item',
                'price' => [
                    'id' => 'price_old',
                    'object' => 'price',
                    'recurring' => ['usage_type' => 'licensed'],
                ],
            ]],
        ],
    ], []);

    // Stripe's upcoming-invoice preview for a mid-cycle swap includes both the
    // proration lines (credit for the old price, charge for the new price for the
    // remainder of the current period) AND the regular charge for the following
    // billing cycle, since that reflects what the customer's actual next invoice
    // will contain.
    $previewInvoice = Util::convertToStripeObject([
        'id' => null,
        'object' => 'invoice',
        'customer' => 'cus_test123',
        'total' => 1000,
        'starting_balance' => 0,
        'currency' => 'usd',
        'lines' => [
            'object' => 'list',
            'has_more' => false,
            'data' => [
                [
                    'id' => 'il_credit_old',
                    'object' => 'line_item',
                    'amount' => -200,
                    'currency' => 'usd',
                    'proration' => true,
                    'period' => ['start' => 1000, 'end' => 2000],
                ],
                [
                    'id' => 'il_charge_new',
                    'object' => 'line_item',
                    'amount' => 400,
                    'currency' => 'usd',
                    'proration' => true,
                    'period' => ['start' => 1000, 'end' => 2000],
                ],
                [
                    'id' => 'il_next_cycle',
                    'object' => 'line_item',
                    'amount' => 800,
                    'currency' => 'usd',
                    'proration' => false,
                    'period' => ['start' => 2000, 'end' => 3000],
                ],
            ],
        ],
    ], []);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('retrieve')->andReturn($stripeSubscription);

    $invoicesMock = Mockery::mock();
    $invoicesMock->shouldReceive('upcoming')->andReturn($previewInvoice);

    $stripeClientMock = new class($subscriptionsMock, $invoicesMock)
    {
        public function __construct(public mixed $subscriptions, public mixed $invoices) {}
    };

    $this->app->bind(StripeClient::class, fn () => $stripeClientMock);

    $price = (new SubscriptionUpgradeService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->upgradePrice();

    expect($price)->toBe(2.0);
});
