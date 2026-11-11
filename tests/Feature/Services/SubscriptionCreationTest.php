<?php

use App\Enums\PricingPeriod;
use App\Exceptions\TranslatableException;
use App\Models\Tier;
use App\Models\TierPrice;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Laravel\Cashier\Subscription;

beforeEach(function (): void {
    config(['services.stripe.lock_store' => 'array', 'services.stripe.enabled' => true]);
    Queue::fake();
    $this->user = User::factory()->create(['stripe_id' => 'cus_duplicate_test']);
    $this->tier = Tier::factory()->create();
    $this->price = TierPrice::factory()->create(['tier_id' => $this->tier->id, 'currency' => $this->user->currency()]);
});

it('rejects an overlapping checkout before making payment changes', function (): void {
    $lock = Cache::store('array')->lock('subscription:user:' . $this->user->id, 600);
    expect($lock->get())->toBeTrue();

    try {
        $this->actingAs($this->user)
            ->post(route('settings.subscription.subscribe', $this->tier), ['payment_id' => 'pm_test'])
            ->assertRedirect(route('settings.subscription'))
            ->assertSessionHas('error_raw', __('subscription.errors.pending'));
    } finally {
        $lock->release();
    }
});

it('reloads subscriptions and treats an already completed checkout as a no-op', function (): void {
    $this->user->load('subscriptions');
    Subscription::create([
        'user_id' => $this->user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_existing',
        'stripe_status' => 'active',
        'stripe_price' => $this->price->stripe_id,
        'quantity' => 1,
    ]);

    (new SubscriptionService)->user($this->user)->tier($this->tier)
        ->period(PricingPeriod::Monthly)->subscribe('pm_test')->finish();

    expect(Subscription::count())->toBe(1);
    Queue::assertNothingPushed();
    expect(Cache::store('array')->lock('subscription:user:' . $this->user->id, 600)->get(fn () => true))->toBeTrue();
});

it('does not create a replacement for a non-terminal subscription and releases the lock on failure', function (string $status): void {
    Subscription::create([
        'user_id' => $this->user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_existing',
        'stripe_status' => $status,
        'stripe_price' => 'price_other',
        'quantity' => 1,
    ]);

    expect(fn () => (new SubscriptionService)->user($this->user)->tier($this->tier)
        ->period(PricingPeriod::Monthly)->subscribe('pm_test'))
        ->toThrow(TranslatableException::class);

    expect(Subscription::count())->toBe(1);
    expect(Cache::store('array')->lock('subscription:user:' . $this->user->id, 600)->get(fn () => true))->toBeTrue();
})->with(['incomplete', 'past_due', 'unpaid', 'paused']);
