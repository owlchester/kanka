<?php

use App\Facades\ApiLog;
use App\Http\Middleware\ApiLogMiddleware;
use App\Models\ApiLog as ApiLogModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    Schema::connection('logs')->create('api_logs', function ($table) {
        $table->id();
        $table->timestamps();
        $table->unsignedInteger('user_id')->nullable();
        $table->unsignedInteger('campaign_id')->nullable();
        $table->text('uri')->nullable();
        $table->json('params')->nullable();
        $table->string('response', 3)->nullable();
        $table->decimal('duration', 8, 3)->nullable();
    });

    Schema::connection('logs')->create('user_logs', function ($table) {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->unsignedTinyInteger('type_id')->default(0);
        $table->unsignedBigInteger('campaign_id')->nullable();
        $table->json('data')->nullable();
        $table->unsignedInteger('impersonated_by')->nullable();
        $table->string('ip', 255)->nullable();
        $table->char('country', 6)->nullable();
        $table->timestamps();
    });
});

it('does not log when logging is disabled', function () {
    config(['logging.enabled' => false]);
    $this->asUser();

    $this->getJson('/api/1.0/profile')->assertSuccessful();

    $this->assertDatabaseCount('api_logs', 0, 'logs');
});

it('logs authenticated campaign API json responses and scrubs password params', function () {
    config(['logging.enabled' => true]);
    $this->asUser()->withCampaign();

    $this->getJson('/api/1.0/campaigns/1/notes?page=2&password=secret')->assertSuccessful();

    $this->assertDatabaseCount('api_logs', 1, 'logs');

    $log = ApiLogModel::query()->firstOrFail();

    expect($log->user_id)->toBe(auth()->id())
        ->and($log->campaign_id)->toBe(1)
        ->and($log->uri)->toBe('api/1.0/campaigns/1/notes')
        ->and($log->params)->toBe(['page' => '2'])
        ->and($log->duration)->not->toBeNull()
        ->and((float) $log->duration)->toBeGreaterThanOrEqual(0.0)
        ->and($log->response)->toBe('200');
});

it('does not log unauthenticated API requests', function () {
    config(['logging.enabled' => true]);

    $this->getJson('/api/1.0/profile')->assertUnauthorized();

    $this->assertDatabaseCount('api_logs', 0, 'logs');
});

it('does not log non-json responses', function () {
    config(['logging.enabled' => true]);
    $this->asUser();

    $request = Request::create('/api/1.0/profile', 'GET');
    $request->setUserResolver(fn () => auth()->user());

    app(ApiLogMiddleware::class)->terminate($request, new Response('ok', 200));

    $this->assertDatabaseCount('api_logs', 0, 'logs');
});

it('logs 500 when an exception is recorded and resets singleton state between requests', function () {
    config(['logging.enabled' => true]);
    $this->asUser()->withCampaign();

    ApiLog::exception(new RuntimeException('boom'));
    $this->getJson('/api/1.0/campaigns/1/notes')->assertSuccessful();

    $this->getJson('/api/1.0/profile')->assertSuccessful();

    $logs = ApiLogModel::query()->orderBy('id')->get();

    expect($logs)->toHaveCount(2)
        ->and($logs[0]->campaign_id)->toBe(1)
        ->and($logs[0]->response)->toBe('500')
        ->and($logs[1]->campaign_id)->toBeNull()
        ->and($logs[1]->uri)->toBe('api/1.0/profile')
        ->and($logs[1]->response)->toBe('200');
});
