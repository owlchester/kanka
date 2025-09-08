<?php

use App\Models\Ability;

it('POSTS a new ability')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/abilities', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all abilities')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->get('/api/1.0/campaigns/1/abilities')
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

it('GETS a specific ability')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->get('/api/1.0/campaigns/1/abilities/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid ability')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->putJson('/api/1.0/campaigns/1/abilities/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid ability without a name')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->putJson('/api/1.0/campaigns/1/abilities/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a ability')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->delete('/api/1.0/campaigns/1/abilities/1')
    ->assertStatus(204);

it('DELETES an invalid ability')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->delete('/api/1.0/campaigns/1/abilities/100')
    ->assertStatus(404);

it('can GET a ability as a player')
    ->asUser()
    ->withCampaign()
    ->withAbilities()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/abilities/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private ability as a player', function () {
    $this->asUser()
        ->withCampaign();

    Ability::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/abilities/1');
    expect($response->status())
        ->toBe(403);
});
