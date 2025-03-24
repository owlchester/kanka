<?php

it('POSTS an invalid relations form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/relations', [])
    ->assertStatus(422);

it('POSTS a new relation')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/relations', [
        'relation' => fake()->text(20),
        'owner_id' => 1,
        'target_id' => 2,
        'two_way' => 0,
        'is_pinned' => 0,
        'visibility_id' => 1,
    ])
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'owner_id',
            ],
        ],
    ]);

it('GETS all relations')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withRelations()
    ->get('/api/1.0/campaigns/1/entities/1/relations')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'owner_id',
            ],
        ],
    ]);

it('GETS a specific relation')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withRelations()
    ->get('/api/1.0/campaigns/1/entities/1/relations/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'owner_id',
        ],
    ]);

it('UPDATES a valid relation')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withRelations()
    ->putJson('/api/1.0/campaigns/1/entities/1/relations/1', ['attitude' => 100])
    ->assertStatus(200)
    ->assertJsonFragment(['attitude' => 100]);

it('DELETES a relation')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withRelations()
    ->delete('/api/1.0/campaigns/1/entities/1/relations/1')
    ->assertStatus(204);

it('DELETES an invalid relation')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withRelations()
    ->delete('/api/1.0/campaigns/1/entities/1/relations/100')
    ->assertStatus(404);
