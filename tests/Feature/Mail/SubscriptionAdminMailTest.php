<?php

use App\Enums\PricingPeriod;
use App\Enums\UserAction;
use App\Jobs\Emails\SubscriptionCreatedEmailJob;
use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\Admin\NewSubscriptionMail;
use App\Models\SubscriptionCancellation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Subscription;

beforeEach(function (): void {
    DB::purge('logs');

    config(['database.connections.logs' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => false,
    ]]);

    Schema::connection('logs')->create('user_logs', function ($table): void {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->unsignedTinyInteger('type_id')->default(UserAction::login->value);
        $table->unsignedBigInteger('campaign_id')->nullable();
        $table->json('data')->nullable();
        $table->unsignedInteger('impersonated_by')->nullable();
        $table->string('ip', 255)->nullable();
        $table->char('country', 6)->nullable();
        $table->timestamps();
    });

    Schema::create('subscription_cancellations', function ($table): void {
        $table->id();
        $table->foreignId('user_id');
        $table->string('reason');
        $table->string('secondary')->nullable();
        $table->text('custom')->nullable();
        $table->string('tier');
        $table->unsignedInteger('duration');
        $table->timestamps();
    });

});

it('includes the latest country with a value in the cancellation email', function (): void {
    $user = User::factory()->create();
    $cancellation = new SubscriptionCancellation;
    $cancellation->setRelation('user', $user);

    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $user->id,
        'type_id' => UserAction::login->value,
        'country' => 'CA',
        'created_at' => Carbon::parse('2026-01-01'),
        'updated_at' => Carbon::parse('2026-01-01'),
    ]);
    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $user->id,
        'type_id' => UserAction::login->value,
        'country' => null,
        'created_at' => Carbon::parse('2026-02-01'),
        'updated_at' => Carbon::parse('2026-02-01'),
    ]);

    $mail = new CancelledSubscriptionMail($cancellation);
    expect($mail->content()->with['country'])->toBe('CA');

    $rendered = $mail->render();

    expect($rendered)
        ->toContain('User country:')
        ->toContain('CA');
});

it('labels a subscription as new when the user has not cancelled before', function (): void {
    $user = User::factory()->create(['pledge' => 'Owlbear']);

    $subject = (new NewSubscriptionMail($user, PricingPeriod::Monthly))->envelope()->subject;

    expect($subject)->toBe('Sub: New Monthly Owlbear');
});

it('labels a subscription as renewed after a previous cancellation', function (): void {
    $user = User::factory()->create(['pledge' => 'Owlbear']);
    SubscriptionCancellation::create([
        'user_id' => $user->id,
        'reason' => 'price',
        'tier' => 'Owlbear',
        'duration' => 30,
    ]);
    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_manual_cancellation_subject',
        'stripe_status' => 'active',
        'stripe_price' => 'price_owlbear',
        'quantity' => 1,
        'ends_at' => now()->addMonth(),
    ]);

    $subject = (new NewSubscriptionMail($user, PricingPeriod::Monthly))->envelope()->subject;

    expect($subject)->toBe('Sub: Renewed Monthly Owlbear');
});

it('does not send the renewed email after an automatic cancellation', function (): void {
    Mail::fake();
    $user = User::factory()->create();

    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_automatic_cancellation',
        'stripe_status' => 'active',
        'stripe_price' => 'price_owlbear',
        'quantity' => 1,
        'ends_at' => now()->addMonth(),
    ]);

    (new SubscriptionCreatedEmailJob($user, PricingPeriod::Monthly))->handle();

    Mail::assertNothingSent();
});

it('sends the renewed email after a manual cancellation', function (): void {
    Mail::fake();
    $user = User::factory()->create();
    SubscriptionCancellation::create([
        'user_id' => $user->id,
        'reason' => 'price',
        'tier' => 'Owlbear',
        'duration' => 30,
    ]);
    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_manual_cancellation',
        'stripe_status' => 'active',
        'stripe_price' => 'price_owlbear',
        'quantity' => 1,
        'ends_at' => now()->addMonth(),
    ]);

    (new SubscriptionCreatedEmailJob($user, PricingPeriod::Monthly))->handle();

    Mail::assertSent(NewSubscriptionMail::class);
});
