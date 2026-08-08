<?php

use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

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

it('creates a stealth post without changing the entity last modified date', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::findOrFail(1);
    $originalUpdatedAt = now()->subHour()->startOfSecond();
    DB::table('entities')->where('id', $entity->id)->update([
        'updated_at' => $originalUpdatedAt,
        'updated_by' => 1,
    ]);

    $this->post(route('entities.posts.store', [1, $entity]), [
        'name' => 'Stealth article',
        'entry' => 'A corrected article.',
        'position' => 1,
        'stealth' => 1,
    ])->assertRedirect();

    $entity->refresh();
    $post = Post::where('name', 'Stealth article')->firstOrFail();

    expect($entity->updated_at->equalTo($originalUpdatedAt))->toBeTrue()
        ->and($entity->updated_by)->toBe(1)
        ->and(EntityLog::where('parent_type', Post::class)
            ->where('parent_id', $post->id)
            ->where('action', EntityLog::ACTION_CREATE_POST)
            ->exists())->toBeTrue();
});

it('updates a stealth post without changing the entity last modified date', function () {
    $this->asUser()->withCampaign()->withCharacters()->withPosts();

    $entity = Entity::findOrFail(1);
    $post = Post::findOrFail(1);
    $originalUpdatedAt = now()->subHour()->startOfSecond();
    DB::table('entities')->where('id', $entity->id)->update([
        'updated_at' => $originalUpdatedAt,
        'updated_by' => 1,
    ]);

    $this->patch(route('entities.posts.update', [1, $entity, $post]), [
        'name' => 'Stealth updated article',
        'stealth' => 1,
    ])->assertRedirect();

    $entity->refresh();
    $post->refresh();

    expect($post->name)->toBe('Stealth updated article')
        ->and($entity->updated_at->equalTo($originalUpdatedAt))->toBeTrue()
        ->and($entity->updated_by)->toBe(1)
        ->and(EntityLog::where('parent_type', Post::class)
            ->where('parent_id', $post->id)
            ->where('action', EntityLog::ACTION_UPDATE_POST)
            ->exists())->toBeTrue();
});

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
