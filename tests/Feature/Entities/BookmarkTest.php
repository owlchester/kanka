<?php

use App\Models\Bookmark;
use App\Models\Tag;

it('syncs bookmark tags through the API', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $tag = Tag::factory()->create(['campaign_id' => 1]);
    $url = '/api/1.0/campaigns/1/bookmarks';

    $id = $this->postJson($url, [
        'name' => 'Tagged bookmark', 'entity_id' => 1, 'save_tags' => 1, 'tags' => [$tag->id],
    ])->assertCreated()->json('data.id');
    $bookmark = Bookmark::findOrFail($id);
    expect($bookmark->tags()->pluck('tags.id')->all())->toBe([$tag->id]);

    $this->putJson("$url/$id", ['name' => 'Cleared bookmark', 'entity_id' => 1, 'save_tags' => 1])
        ->assertOk();
    expect($bookmark->tags()->exists())->toBeFalse();
});

it('POSTS an invalid bookmark form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/bookmarks', [])
    ->assertStatus(422);

it('POSTS a new bookmark')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/bookmarks', [
        'name' => fake()->name(),
        'entity_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
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
    ->withCharacters()
    ->withBookmarks()
    ->putJson('/api/1.0/campaigns/1/bookmarks/1', ['name' => 'Bob', 'entity_id' => 1])
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
