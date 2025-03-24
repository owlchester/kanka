<?php

use App\Models\DiceRoll;

it('POSTS an invalid dice_roll form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/dice_rolls', [])
    ->assertStatus(422);

it('POSTS a new dice_roll')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/dice_rolls', [
        'name' => fake()->name(),
        'parameters' => '2d2',
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all dice_rolls')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->get('/api/1.0/campaigns/1/dice_rolls')
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

it('GETS a specific dice_roll')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->get('/api/1.0/campaigns/1/dice_rolls/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid dice_roll')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->putJson('/api/1.0/campaigns/1/dice_rolls/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid dice_roll without a name')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->putJson('/api/1.0/campaigns/1/dice_rolls/1', ['parameters' => '1d2'])
    ->assertStatus(200)
    ->assertJsonFragment(['parameters' => '1d2']);

it('DELETES a dice_roll')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->delete('/api/1.0/campaigns/1/dice_rolls/1')
    ->assertStatus(204);

it('DELETES an invalid dice_roll')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->delete('/api/1.0/campaigns/1/dice_rolls/100')
    ->assertStatus(404);

it('can GET a dice_roll as a player')
    ->asUser()
    ->withCampaign()
    ->withDiceRolls()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/dice_rolls/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private dice_roll as a player', function () {
    $this->asUser()
        ->withCampaign();

    DiceRoll::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/dice_rolls/1');
    expect($response->status())
        ->toBe(404);
});
