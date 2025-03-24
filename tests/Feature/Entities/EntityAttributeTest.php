<?php

it('POSTS an invalid attributes form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/attributes', [])
    ->assertStatus(422);

it('POSTS a new attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/attributes', [
        'name' => fake()->name(),
        'type_id' => 1,
        'api_key' => '1',
        'value' => 'Entity: [entity:2]',
        'is_hidden' => 0,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all attributes')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->get('/api/1.0/campaigns/1/entities/1/attributes')
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

it('GETS a specific attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->get('/api/1.0/campaigns/1/entities/1/attributes/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->putJson('/api/1.0/campaigns/1/entities/1/attributes/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid attribute without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->putJson('/api/1.0/campaigns/1/entities/1/attributes/1', ['value' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['value' => 'Magic']);

it('DELETES an attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->delete('/api/1.0/campaigns/1/entities/1/attributes/1')
    ->assertStatus(204);

it('DELETES an invalid attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->delete('/api/1.0/campaigns/1/entities/1/attributes/100')
    ->assertStatus(404);
