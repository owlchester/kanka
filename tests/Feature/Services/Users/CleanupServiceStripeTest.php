<?php

use App\Models\User;
use App\Services\Users\CleanupService;
use Stripe\Exception\InvalidRequestException;

it('skips stripe cleanup when user has no stripe id', function () {
    $user = User::factory()->create(['stripe_id' => null]);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldNotReceive('deleteStripeCustomer');
    $mock->shouldNotReceive('updateStripeCustomer');

    $service = app(CleanupService::class)->user($mock);
    expect($service->removeStripeCustomer())->toBeInstanceOf(CleanupService::class);
});

it('deletes stripe customer when user has no subscription history', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test123']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->once();
    $mock->shouldNotReceive('updateStripeCustomer');

    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('anonymizes stripe customer when user has subscription history', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test456']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(true);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldNotReceive('deleteStripeCustomer');
    $mock->shouldReceive('updateStripeCustomer')->once()->with([
        'name' => 'Deleted User',
        'email' => 'deleted+cus_test456@kanka.io',
    ]);

    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('silently ignores resource_missing when deleting stripe customer', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_already_deleted']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $exception = Mockery::mock(InvalidRequestException::class);
    $exception->shouldReceive('getStripeCode')->andReturn('resource_missing');

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->andThrow($exception);

    $service = app(CleanupService::class)->user($mock);
    expect($service->removeStripeCustomer())->toBeInstanceOf(CleanupService::class);
});

it('re-throws unexpected stripe exceptions', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test789']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $exception = Mockery::mock(InvalidRequestException::class);
    $exception->shouldReceive('getStripeCode')->andReturn('card_declined');

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->andThrow($exception);

    expect(fn () => app(CleanupService::class)->user($mock)->removeStripeCustomer())
        ->toThrow(InvalidRequestException::class);
});
