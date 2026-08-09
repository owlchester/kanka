<?php

use App\Enums\UserAction;
use App\Models\User;
use App\Services\Report\WeeklyReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    DB::purge('logs');

    config([
        'database.connections.logs' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ],
        'logging.enabled' => true,
    ]);

    Schema::connection('logs')->create('user_logs', function ($table) {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->unsignedTinyInteger('type_id')->default(UserAction::login->value);
        $table->string('ip', 255)->nullable();
        $table->char('country', 6)->nullable();
        $table->timestamps();
    });
});

it('counts users from login history for each weekly period', function () {
    $previousStart = Carbon::parse('2026-01-01');
    $previousEnd = Carbon::parse('2026-01-08');
    $currentStart = Carbon::parse('2026-01-08');
    $currentEnd = Carbon::parse('2026-01-15');

    $userActiveInBothWeeks = User::factory()->create([
        'created_at' => Carbon::parse('2025-12-01'),
        'last_login_at' => Carbon::parse('2026-01-12'),
    ]);
    $userActiveInPreviousWeek = User::factory()->create([
        'created_at' => Carbon::parse('2025-12-01'),
        'last_login_at' => Carbon::parse('2026-01-07'),
    ]);
    $userActiveInCurrentWeek = User::factory()->create([
        'created_at' => Carbon::parse('2025-12-01'),
        'last_login_at' => Carbon::parse('2026-01-12'),
    ]);

    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $userActiveInBothWeeks->id,
        'type_id' => UserAction::login->value,
        'created_at' => Carbon::parse('2026-01-07'),
        'updated_at' => Carbon::parse('2026-01-07'),
    ]);
    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $userActiveInBothWeeks->id,
        'type_id' => UserAction::autoLogin->value,
        'created_at' => Carbon::parse('2026-01-12'),
        'updated_at' => Carbon::parse('2026-01-12'),
    ]);
    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $userActiveInPreviousWeek->id,
        'type_id' => UserAction::login->value,
        'created_at' => Carbon::parse('2026-01-06'),
        'updated_at' => Carbon::parse('2026-01-06'),
    ]);
    DB::connection('logs')->table('user_logs')->insert([
        'user_id' => $userActiveInCurrentWeek->id,
        'type_id' => UserAction::login->value,
        'created_at' => Carbon::parse('2026-01-12'),
        'updated_at' => Carbon::parse('2026-01-12'),
    ]);

    $service = app(WeeklyReportService::class);

    expect($service->getStats($previousStart, $previousEnd)['weekly_active_users'])->toBe(2)
        ->and($service->getStats($currentStart, $currentEnd)['weekly_active_users'])->toBe(2);
});
