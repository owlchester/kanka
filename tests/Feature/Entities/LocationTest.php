<?php

use App\Models\Location;

it('POSTS an invalid location form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/locations', [])
    ->assertStatus(422);

it('POSTS a new location')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/locations', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all locations')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->get('/api/1.0/campaigns/1/locations')
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

it('GETS a specific location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->get('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->putJson('/api/1.0/campaigns/1/locations/1', ['name' => 'Firelink Shrine'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Firelink Shrine']);

it('UPDATES a valid location without a name')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->putJson('/api/1.0/campaigns/1/locations/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->delete('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(204);

it('DELETES an invalid location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->delete('/api/1.0/campaigns/1/locations/100')
    ->assertStatus(404);

it('can GET a location as a player')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private location as a player', function () {
    $this->asUser()
        ->withCampaign();

    Location::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/locations/1');
    expect($response->status())
        ->toBe(403);
});
