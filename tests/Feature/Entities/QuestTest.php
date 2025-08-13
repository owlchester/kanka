<?php

use App\Models\Quest;

it('POSTS an invalid quest form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/quests', [])
    ->assertStatus(422);

it('POSTS a new quest')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/quests', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all quests')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->get('/api/1.0/campaigns/1/quests')
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

it('GETS a specific quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->get('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->putJson('/api/1.0/campaigns/1/quests/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid quest without a name')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->putJson('/api/1.0/campaigns/1/quests/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->delete('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(204);

it('DELETES an invalid quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->delete('/api/1.0/campaigns/1/quests/100')
    ->assertStatus(404);

it('can GET a quest as a player')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private quest as a player', function () {
    $this->asUser()
        ->withCampaign();

    Quest::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/quests/1');
    expect($response->status())
        ->toBe(403);
});
