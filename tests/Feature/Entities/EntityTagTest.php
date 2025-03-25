<?php

it('POSTS an invalid entity_tags form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_tags', [])
    ->assertStatus(500);

it('POSTS a new entity_tag')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_tags', [
        'entity_id' => 1,
        'tag_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'tag_id',
        ],
    ]);

it('GETS all entity_tags')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->withEntityTags()
    ->get('/api/1.0/campaigns/1/entities/1/entity_tags')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'entity_id',
                'tag_id',
            ],
        ],
    ]);

it('GETS a specific entity_tag')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->withEntityTags()
    ->get('/api/1.0/campaigns/1/entities/1/entity_tags/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'tag_id',
        ],
    ]);

it('UPDATES a valid entity_tag')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->withEntityTags()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_tags/1', ['tag_id' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['tag_id' => 2]);

it('DELETES an entity_tag')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->withEntityTags()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_tags/1')
    ->assertStatus(204);

it('DELETES an invalid entity_tag')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withTags()
    ->withEntityTags()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_tags/100')
    ->assertStatus(404);

// For characters, create a character with 1 tag, and make sure it's in the returned json
it('POSTS a new character with 1 tag')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
        'tags' => [1],
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
            'tags',
        ],
    ])
    ->assertJsonFragment([
        'tags' => [1],
    ]);

// Create a character with two tags in the factory.
// Update the character with one of those tags and a third new tag.
// The result contains one of the original tags + the new tag.

it('PUT the character with 2 tags')
    ->asUser()
    ->withCampaign()
    ->withCharacterTags()
    ->putJson('/api/1.0/campaigns/1/characters/1', [
        'tags' => [1, 3],
        'name' => fake()->name(),
    ])
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
            'tags',
        ],
    ])
    ->assertJsonFragment([
        'tags' => [1, 3],
    ]);

// Create a character with two tags,
// one of the tags is private.
// Get the character asPlayer() and validate that the private tag isn't visible

it('POSTS a new character with a private tag')
    ->asUser()
    ->withCampaign()
    ->withPrivateCharacterTags()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'entity_id',
            'tags',
        ],
    ])
    ->assertJsonFragment([
        'tags' => [1],
    ]);
