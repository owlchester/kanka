<?php

use App\Models\Creature;

it('POSTS an invalid creature form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/creatures', [])
    ->assertStatus(422);

it('POSTS a new creature')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/creatures', [
        'name' => fake()->name(),
        'entry' => 'Entity: [entity:2]',
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all creatures')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/creatures')
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

it('GETS a specific creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->putJson('/api/1.0/campaigns/1/creatures/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid creature without a name')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->putJson('/api/1.0/campaigns/1/creatures/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->delete('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(204);

it('DELETES an invalid creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->delete('/api/1.0/campaigns/1/creatures/100')
    ->assertStatus(404);

it('can GET a creature as a player')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private creature as a player', function () {
    $this->asUser()
        ->withCampaign();

    Creature::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/creatures/1');
    expect($response->status())
        ->toBe(404);
});
