<?php

it('POSTS an invalid quest element form')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->postJson('/api/1.0/campaigns/1/quests/1/quest_elements', [])
    ->assertStatus(422);

it('POSTS a new quest element')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->postJson('/api/1.0/campaigns/1/quests/1/quest_elements', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all quest elements')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->get('/api/1.0/campaigns/1/quests/1/quest_elements')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
            ],
        ],
    ]);

it('GETS a specific quest element')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->get('/api/1.0/campaigns/1/quests/1/quest_elements/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ]);

it('UPDATES a valid quest element')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->putJson('/api/1.0/campaigns/1/quests/1/quest_elements/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid quest element without a name')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->putJson('/api/1.0/campaigns/1/quests/1/quest_elements/1', ['entity_id' => 2, 'role' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['role' => 'Magic']);

it('UPDATES a valid quest element without a name and fails')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->putJson('/api/1.0/campaigns/1/quests/1/quest_elements/1', ['role' => 'Magic'])
    ->assertStatus(422);

it('DELETES a quest element')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->delete('/api/1.0/campaigns/1/quests/1/quest_elements/1')
    ->assertStatus(204);

it('DELETES an invalid quest element')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->delete('/api/1.0/campaigns/1/quests/1/quest_elements/1000')
    ->assertStatus(404);

it('can GET a quest element as a player')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->withQuestElements()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/quests/1/quest_elements/1')
    ->assertStatus(200);
