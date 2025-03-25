<?php

use App\Models\Family;

it('POSTS an invalid family form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/families', [])
    ->assertStatus(422);

it('POSTS a new family')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/families', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all families')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->get('/api/1.0/campaigns/1/families')
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

it('GETS a specific family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->get('/api/1.0/campaigns/1/families/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->putJson('/api/1.0/campaigns/1/families/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid family without a name')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->putJson('/api/1.0/campaigns/1/families/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->delete('/api/1.0/campaigns/1/families/1')
    ->assertStatus(204);

it('DELETES an invalid family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->delete('/api/1.0/campaigns/1/families/100')
    ->assertStatus(404);

it('can GET a family as a player')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/families/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private family as a player', function () {
    $this->asUser()
        ->withCampaign();

    Family::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/families/1');
    expect($response->status())
        ->toBe(404);
});
