<?php

use App\Models\Map;

it('POSTS an invalid map form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/maps', [])
    ->assertStatus(422);

it('POSTS a new map')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/maps', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all maps')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->get('/api/1.0/campaigns/1/maps')
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

it('GETS a specific map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->get('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->putJson('/api/1.0/campaigns/1/maps/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid map without a name')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->putJson('/api/1.0/campaigns/1/maps/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->delete('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(204);

it('DELETES an invalid map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->delete('/api/1.0/campaigns/1/maps/100')
    ->assertStatus(404);

it('can GET a map as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private map as a player', function () {
    $this->asUser()
        ->withCampaign();

    Map::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/maps/1');
    expect($response->status())
        ->toBe(403);
});
