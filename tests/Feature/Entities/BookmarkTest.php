<?php

it('POSTS an invalid bookmark form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/bookmarks', [])
    ->assertStatus(422);

it('POSTS a new bookmark')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/bookmarks', [
        'name' => fake()->name(),
        'type' => 'ability',
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'type',
        ],
    ]);

it('GETS all bookmarks')
    ->asUser()
    ->withCampaign()
    ->withBookmarks()
    ->get('/api/1.0/campaigns/1/bookmarks')
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

it('GETS a specific bookmark')
    ->asUser()
    ->withCampaign()
    ->withBookmarks()
    ->get('/api/1.0/campaigns/1/bookmarks/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid bookmark')
    ->asUser()
    ->withCampaign()
    ->withBookmarks()
    ->putJson('/api/1.0/campaigns/1/bookmarks/1', ['name' => 'Bob', 'type' => 'character'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('DELETES a bookmark')
    ->asUser()
    ->withCampaign()
    ->withBookmarks()
    ->delete('/api/1.0/campaigns/1/bookmarks/1')
    ->assertStatus(204);

it('DELETES an invalid bookmark')
    ->asUser()
    ->withCampaign()
    ->withBookmarks()
    ->delete('/api/1.0/campaigns/1/bookmarks/100')
    ->assertStatus(404);
