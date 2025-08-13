<?php

use App\Models\Tag;

it('POSTS an invalid tag form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/tags', [])
    ->assertStatus(422);

it('POSTS a new tag')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/tags', [
        'name' => fake()->name(),
        'is_hidden' => 0,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all tags')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->get('/api/1.0/campaigns/1/tags')
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

it('GETS a specific tag')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->get('/api/1.0/campaigns/1/tags/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid tag')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->putJson('/api/1.0/campaigns/1/tags/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid tag without a name')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->putJson('/api/1.0/campaigns/1/tags/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a tag')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->delete('/api/1.0/campaigns/1/tags/1')
    ->assertStatus(204);

it('DELETES an invalid tag')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->delete('/api/1.0/campaigns/1/tags/100')
    ->assertStatus(404);

it('can GET a tag as a player')
    ->asUser()
    ->withCampaign()
    ->withTags()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/tags/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private tag as a player', function () {
    $this->asUser()
        ->withCampaign();

    Tag::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/tags/1');
    expect($response->status())
        ->toBe(403);
});
