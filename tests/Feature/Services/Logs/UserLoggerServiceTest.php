<?php

use App\Enums\UserAction;
use App\Facades\UserLogger;
use App\Models\User;
use App\Services\Logs\UserLoggerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    DB::purge('logs');

    config(['database.connections.logs' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => false,
    ]]);

    Schema::connection('logs')->create('user_logs', function ($table) {
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

    $this->assertDatabaseCount('user_logs', 0, 'logs');
});

it('user() returns the service for chaining', function () {
    $user = User::factory()->create();
    $service = app(UserLoggerService::class);

    expect($service->user($user))->toBe($service);
});

it('log() persists a UserLog record', function () {
    config(['logging.enabled' => true]);
    $user = User::factory()->create();

    UserLogger::user($user)->log(UserAction::login);

    $this->assertDatabaseHas('user_logs', [
        'user_id' => $user->id,
        'type_id' => UserAction::login->value,
    ], 'logs');
});

it('campaign() persists a UserLog record with campaign data', function () {
    config(['logging.enabled' => true]);
    $user = User::factory()->create();

    UserLogger::user($user)->campaign(42, 'members', 'joined', ['invite' => 7]);

    $this->assertDatabaseHas('user_logs', [
        'user_id' => $user->id,
        'type_id' => UserAction::campaign->value,
        'campaign_id' => 42,
    ], 'logs');
});
