<?php

use App\Enums\UserAction;
use App\Jobs\Emails\Subscriptions\Admin\PaypalRenewedJob;
use App\Mail\Subscription\Admin\CancelledSubscriptionMail;
use App\Mail\Subscription\Admin\PaypalRenewedMail;
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

it('does not send the paypal renewed email without a cancelled subscription', function (): void {
    Mail::fake();
    $user = User::factory()->create();

    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_active',
        'stripe_status' => 'active',
        'stripe_price' => 'paypal_Owlbear',
        'quantity' => 1,
    ]);

    (new PaypalRenewedJob($user->id))->handle();

    Mail::assertNothingSent();
});

it('sends the paypal renewed email after a cancelled subscription', function (): void {
    Mail::fake();
    $user = User::factory()->create();

    Subscription::create([
        'user_id' => $user->id,
        'type' => 'kanka',
        'stripe_id' => 'sub_cancelled',
        'stripe_status' => 'active',
        'stripe_price' => 'paypal_Owlbear',
        'quantity' => 1,
        'ends_at' => now()->addYear(),
    ]);

    (new PaypalRenewedJob($user->id))->handle();

    Mail::assertSent(PaypalRenewedMail::class);
});
