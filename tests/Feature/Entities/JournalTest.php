<?php

use App\Models\Journal;

it('POSTS an invalid journal form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/journals', [])
    ->assertStatus(422);

it('POSTS a new journal')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/journals', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all journals')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->get('/api/1.0/campaigns/1/journals')
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

it('GETS a specific journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->get('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->putJson('/api/1.0/campaigns/1/journals/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid journal without a name')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->putJson('/api/1.0/campaigns/1/journals/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->delete('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(204);

it('DELETES an invalid journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->delete('/api/1.0/campaigns/1/journals/100')
    ->assertStatus(404);

it('can GET a journal as a player')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private journal as a player', function () {
    $this->asUser()
        ->withCampaign();

    Journal::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/journals/1');
    expect($response->status())
        ->toBe(403);
});
