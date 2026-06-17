<?php

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Models\User;
use App\Services\Logs\UserLoggerService;

it('resolves UserLoggerService via facade', function () {
    $user = User::factory()->create();
    $service = UserLogger::user($user);

    expect($service)->toBeInstanceOf(UserLoggerService::class)
        ->and($service->user)->toBe($user);
});

it('does nothing when logging is disabled', function () {
    config(['logging.enabled' => false]);
    $user = User::factory()->create();

    UserLogger::user($user)->log(UserAction::login);
    UserLogger::user($user)->campaign(1, 'members', 'joined');

    expect(true)->toBeTrue();
});

it('user() returns the service for chaining', function () {
    $user = User::factory()->create();
    $service = app(UserLoggerService::class);

    expect($service->user($user))->toBe($service);
});
