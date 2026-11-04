<?php

use App\Models\Creature;
use App\Models\Entity;

it('POSTS an invalid conversation message form')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_messages', [
    ])
    ->assertStatus(422);

it('POSTS a new conversation message')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_messages', [
        'entity_id' => 2,
        'conversation_id' => 1,
        'message' => 'cookies',
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'conversation_id',
            'message',
        ],
    ]);

it('rejects character_id as a message author')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_messages', [
        'character_id' => 1,
        'message' => 'Legacy request',
    ])
    ->assertUnprocessable();

it('GETS all conversation messages')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationMessages()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_messages')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'entity_id',
                'conversation_id',
            ],
        ],
    ]);

it('GETS a specific conversation message')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationMessages()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_messages/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'conversation_id',
        ],
    ]);

it('UPDATES a valid conversation message')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationMessages()
    ->putJson('/api/1.0/campaigns/1/conversations/1/conversation_messages/1', ['message' => 'cookies'])
    ->assertStatus(200)
    ->assertJsonFragment(['message' => 'cookies']);

it('DELETES a conversation message')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationMessages()
    ->delete('/api/1.0/campaigns/1/conversations/1/conversation_messages/1')
    ->assertStatus(204);

it('DELETES an invalid conversation message')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->delete('/api/1.0/campaigns/1/conversations/1/conversation_messages/100')
    ->assertStatus(404);

it('can GET a conversation as a player')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationMessages()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_messages/1')
    ->assertStatus(200);

it('allows an entity other than a character to author a message', function () {
    $this->asUser()->withCampaign()->withConversations(['target_id' => 2]);
    $creature = Creature::factory()->create(['campaign_id' => 1]);
    $entityId = Entity::where('type_id', config('entities.ids.creature'))
        ->where('entity_id', $creature->id)
        ->value('id');

    $this->postJson('/api/1.0/campaigns/1/conversations/1/conversation_messages', [
        'entity_id' => $entityId,
        'message' => 'The creature speaks.',
    ])
        ->assertCreated()
        ->assertJsonPath('data.entity_id', $entityId);
});
