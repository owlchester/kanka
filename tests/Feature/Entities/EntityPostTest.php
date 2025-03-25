<?php

it('POSTS an invalid posts form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/posts', [])
    ->assertStatus(422);

it('POSTS a new post')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/posts', [
        'name' => fake()->name(),
        'entity_id' => 1,
        'position' => 1,
        'entry' => 'Entity: [entity:2]',
        'is_template' => false,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all posts')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->get('/api/1.0/campaigns/1/entities/1/posts')
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

it('GETS a specific post')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->get('/api/1.0/campaigns/1/entities/1/posts/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid post')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->putJson('/api/1.0/campaigns/1/entities/1/posts/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid post without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->putJson('/api/1.0/campaigns/1/entities/1/posts/1', ['position' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['position' => 2]);

it('DELETES an post')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->delete('/api/1.0/campaigns/1/entities/1/posts/1')
    ->assertStatus(204);

it('DELETES an invalid post')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->delete('/api/1.0/campaigns/1/entities/1/posts/100')
    ->assertStatus(404);
