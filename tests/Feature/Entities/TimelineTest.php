<?php

use App\Models\Timeline;

it('POSTS an invalid timeline form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/timelines', [])
    ->assertStatus(422);

it('POSTS a new timeline')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/timelines', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all timelines')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->get('/api/1.0/campaigns/1/timelines')
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

it('GETS a specific timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->get('/api/1.0/campaigns/1/timelines/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->putJson('/api/1.0/campaigns/1/timelines/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid timeline without a name')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->putJson('/api/1.0/campaigns/1/timelines/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->delete('/api/1.0/campaigns/1/timelines/1')
    ->assertStatus(204);

it('DELETES an invalid timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->delete('/api/1.0/campaigns/1/timelines/100')
    ->assertStatus(404);

it('can GET a timeline as a player')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/timelines/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private timeline as a player', function () {
    $this->asUser()
        ->withCampaign();

    Timeline::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/timelines/1');
    expect($response->status())
        ->toBe(404);
});
