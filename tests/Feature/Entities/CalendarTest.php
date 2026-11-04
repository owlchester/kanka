<?php

use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Event;
use App\Models\Reminder;
use App\Services\Campaign\Import\Mappers\CalendarMapper;
use Carbon\Carbon;

it('POSTS an invalid calendar form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/calendars', [])
    ->assertStatus(422);

it('POSTS a new calendar')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/calendars', [
        'name' => 'Gregorian',
        'month_name' => ['first', 'last'],
        'month_length' => [1, 2],
        'weekday' => ['monday', 'sunday'],
        'eras' => [
            ['name' => 'The First Age', 'suffix' => '1A', 'start_year' => null, 'end_year' => 1000],
            ['name' => 'The Second Age', 'suffix' => '2A', 'start_year' => 1001, 'end_year' => null],
        ],
        'suffix' => 'AD',
        'has_leap_year' => 1,
        'leap_year_amount' => 1,
        'leap_year_month' => 2,
        'leap_year_offset' => 4,
        'leap_year_start' => 4,
        'skip_year_zero' => 1,
        'start_offset' => 5,
        'is_incrementing' => 1,
        'date' => Carbon::now()->toDateString(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ])
    ->assertJsonPath('data.eras.0.name', 'The First Age')
    ->assertJsonPath('data.eras.1.suffix', '2A');

it('formats calendar years using era boundaries', function () {
    $calendar = Calendar::factory()->make([
        'eras' => [
            ['name' => 'The First Age', 'suffix' => '1A', 'start_year' => null, 'end_year' => 1000],
            ['name' => 'The Second Age', 'suffix' => '2A', 'start_year' => 1001, 'end_year' => null],
        ],
    ]);

    expect($calendar->yearName(1000))->toBe('1000 1A')
        ->and($calendar->yearName(1001))->toBe('1 2A')
        ->and($calendar->yearName(1005))->toBe('5 2A');
});

it('exposes eras in calendar API responses', function () {
    $this->asUser()
        ->withCampaign()
        ->withCalendars()
        ->get('/api/1.0/campaigns/1/calendars/1')
        ->assertSuccessful()
        ->assertJsonPath('data.eras', []);
});

it('formats negative years in an end-only era without a minus sign', function () {
    $calendar = Calendar::factory()->make([
        'eras' => [
            ['name' => 'Before Common Era', 'suffix' => 'BCE', 'start_year' => null, 'end_year' => -1],
            ['name' => 'Common Era', 'suffix' => 'CE', 'start_year' => 1, 'end_year' => null],
        ],
    ]);

    expect($calendar->yearName(-5))->toBe('5 BCE')
        ->and($calendar->yearName(-1))->toBe('1 BCE')
        ->and($calendar->yearName(1))->toBe('1 CE')
        ->and($calendar->niceDate('-5-1-1'))->toBe('1 January, 5 BCE');
});

it('round trips calendar configuration through native array casts', function (string $field, array $value) {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1, $field => $value]);

    expect($calendar->fresh()->{$field})->toBe($value)
        ->and(json_decode($calendar->getRawOriginal($field), true))->toBe($value);

    $calendar->{$field} = [];
    expect($calendar->{$field})->toBe([]);
    $calendar->save();
    expect($calendar->fresh()->{$field})->toBe([]);
})->with([
    'months' => ['months', [['name' => 'First', 'length' => 30]]],
    'weekdays' => ['weekdays', ['First', 'Second']],
    'years' => ['years', [0 => 'Origin', 1005 => 'Dragon']],
    'eras' => ['eras', [['name' => 'Common Era', 'suffix' => 'CE', 'start_year' => 1, 'end_year' => null]]],
    'seasons' => ['seasons', [['name' => 'Spring', 'month' => 1, 'day' => 1]]],
    'moons' => ['moons', [['name' => 'Luna', 'fullmoon' => 28]]],
    'week names' => ['week_names', [1 => 'First week']],
    'month aliases' => ['month_aliases', ['First']],
]);

it('reads existing calendar JSON without encoding it again', function () {
    $calendar = new Calendar;
    $calendar->setRawAttributes([
        'months' => '[{"name":"First","length":30}]',
        'years' => '{"0":"Origin","1005":"Dragon"}',
        'eras' => null,
    ]);

    expect($calendar->months)->toBe([['name' => 'First', 'length' => 30]])
        ->and($calendar->years)->toBe([0 => 'Origin', 1005 => 'Dragon'])
        ->and($calendar->eras)->toBeNull()
        ->and($calendar->eraYearName(1005))->toBeNull();
});

it('preserves named year maps as objects in the calendar API', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1, 'years' => [0 => 'Origin']]);

    $response = $this->getJson('/api/1.0/campaigns/1/calendars/' . $calendar->id)
        ->assertSuccessful()
        ->assertJsonPath('data.years.0', 'Origin');

    expect(json_decode($response->getContent())->data->years)->toBeInstanceOf(stdClass::class);
});

it('imports calendar configuration from legacy strings and array exports', function (bool $legacy) {
    $this->asUser()->withCampaign();
    $months = [['name' => 'First', 'length' => 30]];
    $years = [0 => 'Origin', 1005 => 'Dragon'];

    app(CalendarMapper::class)
        ->campaign(Campaign::findOrFail(1))
        ->user(auth()->user())
        ->data([
            'id' => 123,
            'entity' => ['id' => 456, 'name' => 'Imported calendar'],
            'months' => $legacy ? json_encode($months) : $months,
            'years' => $legacy ? json_encode($years) : $years,
        ])
        ->first();

    $calendar = Calendar::firstOrFail();
    expect($calendar->months)->toBe($months)
        ->and($calendar->years)->toBe($years);
})->with(['legacy' => true, 'arrays' => false]);

it('GETS all calendars')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->get('/api/1.0/campaigns/1/calendars')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific calendar')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->get('/api/1.0/campaigns/1/calendars/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid calendar')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->putJson('/api/1.0/campaigns/1/calendars/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid calendar without a name')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->putJson('/api/1.0/campaigns/1/calendars/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a calendar')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->delete('/api/1.0/campaigns/1/calendars/1')
    ->assertStatus(204);

it('DELETES an invalid calendar')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->delete('/api/1.0/campaigns/1/calendars/100')
    ->assertStatus(404);

it('can GET a calendar as a player')
    ->asUser()
    ->withCampaign()
    ->withCalendars()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/calendars/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private calendar as a player', function () {
    $this->asUser()
        ->withCampaign();

    Calendar::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/calendars/1');
    expect($response->status())
        ->toBe(403);
});

it('links the calendar overview today button to the calendar date', function () {
    $this->asUser()->withCampaign();

    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '3-5-10',
    ]);

    $todayUrl = route('entities.show', [
        $calendar->campaign,
        'entity' => $calendar->entity,
        'month' => 5,
        'year' => 3,
    ]);

    $viewedUrl = route('entities.show', [
        $calendar->campaign,
        'entity' => $calendar->entity,
        'month' => 2,
        'year' => 9,
    ]);

    $this->get($viewedUrl)
        ->assertSuccessful()
        ->assertSee('href="' . e($todayUrl) . '"', false);
});

it('ignores malformed calendar navigation parameters', function (string $property) {
    $this->asUser()->withCampaign();

    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-1',
    ]);
    $payload = "-5' UNION ALL SELECT NULL,'hizxaulzkpzgiclivxhovahfhvgfrcwu',NULL,NULL-- th22t0";
    $url = route('entities.show', [$calendar->campaign, $calendar->entity]) . '?' . http_build_query([
        $property => $payload,
    ]);

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('data-date="1-1-1"', false);
})->with(['month', 'year']);

it('renders years before the first leap year consistently', function (string $layout) {
    $this->asUser()->withCampaign();

    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-1',
        'months' => [
            ['name' => 'First', 'length' => 30, 'type' => 'standard', 'alias' => ''],
        ],
        'seasons' => [],
        'leap_year_amount' => 1,
        'leap_year_month' => 1,
        'leap_year_offset' => 4,
        'leap_year_start' => 5,
    ]);

    $route = fn (int $year): string => route('entities.show', [
        $calendar->campaign,
        'entity' => $calendar->entity,
        'layout' => $layout,
        'month' => 1,
        'year' => $year,
    ]);

    $this->get($route(1))
        ->assertSuccessful()
        ->assertSee('data-date="1-1-30"', false)
        ->assertDontSee('data-date="1-1-31"', false);

    $this->get($route(5))
        ->assertSuccessful()
        ->assertSee('data-date="5-1-31"', false);
})->with(['month', 'year']);

it('renders calendars with subtractive leap years', function () {
    $this->asUser()->withCampaign();

    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-2-27',
        'leap_year_amount' => -1,
        'leap_year_month' => 2,
        'leap_year_offset' => 1,
        'leap_year_start' => 1,
    ]);

    $this->get(route('entities.show', [$calendar->campaign, $calendar->entity]))
        ->assertSuccessful()
        ->assertSee('data-date="1-2-27"', false)
        ->assertDontSee('data-date="1-2-28"', false);
});

it('warns about invalid leap rules instead of crashing', function () {
    $this->asUser()->withCampaign();

    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'leap_year_amount' => -28,
        'leap_year_month' => 2,
        'leap_year_offset' => 1,
        'leap_year_start' => 1,
    ]);

    $this->get(route('entities.show', [$calendar->campaign, $calendar->entity]))
        ->assertSuccessful()
        ->assertSee(__('calendars.show.missing_details'));
});

it('renders a recurring intermediate moon phase reminder on its phase date', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'date' => '1-1-3',
        'moons' => [
            ['id' => 1, 'name' => 'Luna', 'fullmoon' => 16, 'offset' => 0, 'colour' => 'grey'],
        ],
    ]);
    $event = Event::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'year' => 1,
        'month' => 1,
        'day' => 1,
        'is_recurring' => true,
        'recurring_periodicity' => '1_waning_gibbous',
        'remindable_id' => $event->entity->id,
        'remindable_type' => Entity::class,
    ]);

    $this->get(route('entities.show', [$calendar->campaign, $calendar->entity]))
        ->assertSuccessful()
        ->assertSee('Luna waning gibbous', false);
});
