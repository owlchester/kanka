<?php

use App\Enums\PricingPeriod;
use App\Jobs\Emails\SubscriptionDowngradedEmailJob;
use App\Models\SubscriptionCancellation;
use App\Models\Tier;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;

beforeEach(function (): void {
    Queue::fake();

    Schema::create('subscription_cancellations', function ($table): void {
        $table->id();
        $table->foreignId('user_id');
        $table->string('reason')->nullable();
        $table->string('secondary')->nullable();
        $table->text('custom')->nullable();
        $table->string('tier');
        $table->string('new_tier')->nullable();
        $table->unsignedInteger('duration');
        $table->timestamps();
    });
});

it('records a downgrade with its feedback and subscription duration', function (): void {
    $user = User::factory()->create(['pledge' => 'Wyvern']);
    $tier = Tier::factory()->create(['name' => 'Owlbear']);
    $subscription = Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_downgrade_record',
        'stripe_status' => 'active',
        'stripe_price' => 'price_wyvern',
        'quantity' => 1,
        'created_at' => now()->subDays(30),
        'ends_at' => now()->addMonth(),
    ]);

    (new SubscriptionService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->request([
            'reason' => 'financial',
            'reason_custom' => 'Too expensive',
        ])
        ->finish();

    $cancellation = SubscriptionCancellation::query()->sole();

    expect($cancellation->user_id)->toBe($user->id)
        ->and($cancellation->tier)->toBe('Wyvern')
        ->and($cancellation->new_tier)->toBe('Owlbear')
        ->and($cancellation->reason)->toBe('financial')
        ->and($cancellation->custom)->toBe('Too expensive')
        ->and($cancellation->duration)->toBe(30);

    Queue::assertPushed(SubscriptionDowngradedEmailJob::class);
    expect($subscription->fresh()->stripe_price)->toBe('price_wyvern');
});

it('records a downgrade without optional feedback', function (): void {
    $user = User::factory()->create(['pledge' => 'Wyvern']);
    $tier = Tier::factory()->create(['name' => 'Owlbear']);
    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_downgrade_no_feedback',
        'stripe_status' => 'active',
        'stripe_price' => 'price_wyvern',
        'quantity' => 1,
        'created_at' => now()->subDays(30),
        'ends_at' => now()->addMonth(),
    ]);

    (new SubscriptionService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->request([])
        ->finish();

    expect(SubscriptionCancellation::query()->sole()->reason)->toBeNull();
});

it('does not record a second row when the downgrade webhook finishes the change', function (): void {
    $user = User::factory()->create(['pledge' => 'Wyvern']);
    $tier = Tier::factory()->create(['name' => 'Owlbear']);
    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_downgrade_webhook',
        'stripe_status' => 'active',
        'stripe_price' => 'price_wyvern',
        'quantity' => 1,
        'created_at' => now()->subDays(30),
        'ends_at' => now()->addMonth(),
    ]);

    $service = (new SubscriptionService)
        ->user($user)
        ->tier($tier)
        ->period(PricingPeriod::Monthly)
        ->request(['reason' => 'financial'])
        ->finish();

    $service->webhook()->finish();

    expect(SubscriptionCancellation::query()->count())->toBe(1);
});
