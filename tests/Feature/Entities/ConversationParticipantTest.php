<?php

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
        'character_id' => 1,
        'conversation_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'character_id',
            'conversation_id',
        ],
    ]);

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
                'character_id',
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
            'character_id',
            'conversation_id',
        ],
    ]);

it('UPDATES a valid conversation participant')
    ->asUser()
    ->withCampaign()
    ->withConversations()
    ->withCharacters()
    ->withConversationParticipants()
    ->putJson('/api/1.0/campaigns/1/conversations/1/conversation_participants/1', ['character_id' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['character_id' => 2]);

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
