<?php

use App\Models\Calendar;
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
        'months' => '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"February","length":28,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""},{"name":"April","length":30,"type":"standard","alias":""},{"name":"Mai","length":31,"type":"standard","alias":""},{"name":"June","length":30,"type":"standard","alias":""},{"name":"July","length":31,"type":"standard","alias":""},{"name":"August","length":31,"type":"standard","alias":""},{"name":"September","length":30,"type":"standard","alias":""},{"name":"October","length":31,"type":"standard","alias":""},{"name":"November","length":30,"type":"standard","alias":""},{"name":"December","length":31,"type":"standard","alias":""}]',
        'weekdays' => '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]',
        'seasons' => '[{"name":"Spring","month":3,"day":21},{"name":"Summer","month":6,"day":21},{"name":"Autumn","month":9,"day":21},{"name":"Winter","month":12,"day":21}]',
        'month_name' => ['first', 'last'],
        'month_length' => [1, 2],
        'weekday' => ['monday', 'sunday'],
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
    ]);

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
