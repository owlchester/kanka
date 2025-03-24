<?php

use App\Models\Character;

it('POSTS an invalid character form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [])
    ->assertStatus(422);

it('POSTS a new character')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all characters')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->get('/api/1.0/campaigns/1/characters')
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

it('GETS a specific character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->get('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->putJson('/api/1.0/campaigns/1/characters/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid character without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->putJson('/api/1.0/campaigns/1/characters/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->delete('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(204);

it('DELETES an invalid character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->delete('/api/1.0/campaigns/1/characters/100')
    ->assertStatus(404);

it('can GET a character as a player')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private character as a player', function () {
    $this->asUser()
        ->withCampaign();

    Character::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/characters/1');
    expect($response->status())
        ->toBe(404);
});
