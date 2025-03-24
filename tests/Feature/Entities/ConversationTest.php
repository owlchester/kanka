<?php

use App\Models\Conversation;

it('POSTS an invalid conversation form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/conversations', [])
    ->assertStatus(422);

it('POSTS a new conversation')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/conversations', [
        'name' => fake()->name(),
        'target_id' => 2,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all conversations')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->get('/api/1.0/campaigns/1/conversations')
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

it('GETS a specific conversation')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->get('/api/1.0/campaigns/1/conversations/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid conversation')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->putJson('/api/1.0/campaigns/1/conversations/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid conversation without a name')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->putJson('/api/1.0/campaigns/1/conversations/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a conversation')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->delete('/api/1.0/campaigns/1/conversations/1')
    ->assertStatus(204);

it('DELETES an invalid conversation')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->delete('/api/1.0/campaigns/1/conversations/100')
    ->assertStatus(404);

it('can GET a conversation as a player')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/conversations/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private conversation as a player', function () {
    $this->asUser()
        ->withCampaign();

    Conversation::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/conversations/1');
    expect($response->status())
        ->toBe(404);
});
