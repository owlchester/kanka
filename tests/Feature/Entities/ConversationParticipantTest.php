<?php

use App\Models\Creature;
use App\Models\Entity;

it('POSTS an invalid conversation participant form')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_participants', [
    ])
    ->assertStatus(422);

it('POSTS a new conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_participants', [
        'entity_id' => 2,
        'conversation_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'conversation_id',
        ],
    ]);

it('rejects character_id as a participant target')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/conversations/1/conversation_participants', [
        'character_id' => 1,
    ])
    ->assertUnprocessable();

it('GETS all conversation participants')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_participants')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'entity_id',
                'conversation_id',
            ],
        ],
    ]);

it('GETS a specific conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_participants/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'conversation_id',
        ],
    ]);

it('UPDATES a valid conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->putJson('/api/1.0/campaigns/1/conversations/1/conversation_participants/1', ['entity_id' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['entity_id' => 2]);

it('DELETES a conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->delete('/api/1.0/campaigns/1/conversations/1/conversation_participants/1')
    ->assertStatus(204);

it('DELETES an invalid conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->delete('/api/1.0/campaigns/1/conversations/1/conversation_participants/100')
    ->assertStatus(404);

it('can GET a conversation as a player')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/conversations/1/conversation_participants/1')
    ->assertStatus(200);

it('allows any entity type to participate in an entity conversation', function () {
    $this->asUser()->withCampaign()->withConversations(['target_id' => 2]);
    $creature = Creature::factory()->create(['campaign_id' => 1]);
    $entityId = Entity::where('type_id', config('entities.ids.creature'))
        ->where('entity_id', $creature->id)
        ->value('id');

    $this->postJson('/api/1.0/campaigns/1/conversations/1/conversation_participants', [
        'entity_id' => $entityId,
    ])
        ->assertCreated()
        ->assertJsonPath('data.entity_id', $entityId);

    expect(Entity::findOrFail($entityId)->conversations()->where('conversations.id', 1)->exists())->toBeTrue();
});
