<?php

use App\Models\Calendar;
use App\Models\Event;
use App\Models\Reminder;
use App\Services\Calendars\ReminderService;

function calendarReminder(Calendar $calendar, Event $event, array $attributes): Reminder
{
    $reminder = new Reminder($attributes + [
        'calendar_id' => $calendar->id,
        'length' => 1,
        'visibility_id' => 1,
    ]);
    $reminder->remindable()->associate($event->entity);
    $reminder->save();

    return $reminder;
}

it('returns active recurring reminders in upcoming and concrete previous occurrences', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-10',
    ]);
    $event = Event::factory()->create(['campaign_id' => 1]);
    calendarReminder($calendar, $event, [
        'year' => -1,
        'month' => 12,
        'day' => 9,
        'length' => 2,
        'is_recurring' => true,
        'recurring_periodicity' => 'month',
    ]);

    $window = app(ReminderService::class)->calendar($calendar)->around(5);

    expect($window->past)->toHaveCount(1)
        ->and($window->past->first()->occurrence->start->key())->toBe('-1-12-9')
        ->and($window->upcoming)->toHaveCount(1)
        ->and($window->upcoming->first()->isActive())->toBeTrue();
});

it('sorts by actual occurrence instead of reminder anchor order', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-1',
    ]);
    $firstEvent = Event::factory()->create(['campaign_id' => 1]);
    $secondEvent = Event::factory()->create(['campaign_id' => 1]);

    calendarReminder($calendar, $firstEvent, [
        'year' => -20,
        'month' => 1,
        'day' => 20,
        'is_recurring' => true,
        'recurring_periodicity' => 'year',
    ]);
    $second = calendarReminder($calendar, $secondEvent, [
        'year' => 1,
        'month' => 1,
        'day' => 3,
        'is_recurring' => false,
    ]);

    $window = app(ReminderService::class)->calendar($calendar)->around(1);

    expect($window->upcoming->first()->reminder->is($second))->toBeTrue();
});

it('renders intermediate moon phase reminders in the calendar window', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-3',
        'moons' => json_encode([
            ['id' => 1, 'name' => 'Luna', 'fullmoon' => 16, 'offset' => 0, 'colour' => 'grey'],
        ]),
    ]);
    $event = Event::factory()->create(['campaign_id' => 1]);
    calendarReminder($calendar, $event, [
        'year' => 1,
        'month' => 1,
        'day' => 1,
        'is_recurring' => true,
        'recurring_periodicity' => '1_waning_gibbous',
    ]);

    $window = app(ReminderService::class)->calendar($calendar)->around(5);

    expect($window->upcoming->first()->occurrence->start->key())->toBe('1-1-3');
});
