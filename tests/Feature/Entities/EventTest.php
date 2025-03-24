<?php

use App\Models\Event;

it('POSTS an invalid event form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/events', [])
    ->assertStatus(422);

it('POSTS a new event')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/events', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all events')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->get('/api/1.0/campaigns/1/events')
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

it('GETS a specific event')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->get('/api/1.0/campaigns/1/events/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid event')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->putJson('/api/1.0/campaigns/1/events/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid event without a name')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->putJson('/api/1.0/campaigns/1/events/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a event')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->delete('/api/1.0/campaigns/1/events/1')
    ->assertStatus(204);

it('DELETES an invalid event')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->delete('/api/1.0/campaigns/1/events/100')
    ->assertStatus(404);

it('can GET a event as a player')
    ->asUser()
    ->withCampaign()
    ->withEvents()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/events/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private event as a player', function () {
    $this->asUser()
        ->withCampaign();

    Event::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/events/1');
    expect($response->status())
        ->toBe(404);
});
