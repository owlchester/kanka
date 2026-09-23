<?php

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;
use App\Services\Calendars\AdvancerService;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Queue;

it('does not report invalid calendar configuration', function () {
    Exceptions::fake();
    $this->asUser()->withCampaign();

    $emptyMonths = Calendar::factory()->create([
        'campaign_id' => 1,
        'months' => '[]',
        'date' => '1-1-1',
    ]);
    $invalidLeapRule = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-1',
        'leap_year_amount' => -1,
    ]);

    $this->artisan('calendar:advance')
        ->expectsOutputToContain("Calendar {$emptyMonths->id}: InvalidArgumentException: A calendar must define at least one month.")
        ->expectsOutputToContain("Calendar {$invalidLeapRule->id}: InvalidArgumentException: Invalid calendar leap rule.")
        ->assertSuccessful();

    Exceptions::assertNothingReported();
});

it('continues advancing valid calendars after invalid configuration', function () {
    Queue::fake();
    $this->asUser()->withCampaign();

    Calendar::factory()->create([
        'campaign_id' => 1,
        'months' => '[]',
        'date' => '1-1-1',
    ]);
    $validCalendar = Calendar::factory()->create(['campaign_id' => 1, 'date' => '1-1-1']);

    $this->artisan('calendar:advance')->assertSuccessful();

    expect($validCalendar->fresh()->date)->toBe('1-1-2');
    Queue::assertPushed(CalendarsClearElapsed::class, fn ($job) => $job->calendar->is($validCalendar));
});

it('reports unexpected calendar advancement failures', function () {
    Exceptions::fake();
    $this->asUser()->withCampaign();
    $this->mock(AdvancerService::class, function ($mock): void {
        $mock->shouldReceive('calendar')->once()->andReturnSelf();
        $mock->shouldReceive('advance')->once()->andThrow(new RuntimeException('Unexpected failure'));
    });

    $calendar = Calendar::factory()->create(['campaign_id' => 1, 'date' => '1-1-1']);

    $this->artisan('calendar:advance')->assertSuccessful();

    Exceptions::assertReported(fn (RuntimeException $exception): bool => str_contains($exception->getMessage(), "Calendar {$calendar->id}")
        && $exception->getPrevious() instanceof RuntimeException
        && $exception->getPrevious()->getMessage() === 'Unexpected failure'
    );
});
