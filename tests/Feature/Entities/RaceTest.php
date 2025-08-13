<?php

use App\Models\Race;

it('POSTS an invalid race form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/races', [])
    ->assertStatus(422);

it('POSTS a new race')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/races', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all races')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->get('/api/1.0/campaigns/1/races')
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

it('GETS a specific race')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->get('/api/1.0/campaigns/1/races/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid race')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->putJson('/api/1.0/campaigns/1/races/1', ['name' => 'Goblin'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Goblin']);

it('UPDATES a valid race without a name')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->putJson('/api/1.0/campaigns/1/races/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a race')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->delete('/api/1.0/campaigns/1/races/1')
    ->assertStatus(204);

it('DELETES an invalid race')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->delete('/api/1.0/campaigns/1/races/100')
    ->assertStatus(404);

it('can GET a race as a player')
    ->asUser()
    ->withCampaign()
    ->withRaces()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/races/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private race as a player', function () {
    $this->asUser()
        ->withCampaign();

    Race::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/races/1');
    expect($response->status())
        ->toBe(403);
});
