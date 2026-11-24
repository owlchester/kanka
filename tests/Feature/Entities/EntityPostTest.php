<?php

use App\Models\Calendar;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

it('syncs post tags and reminders through the API', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $tag = Tag::factory()->create(['campaign_id' => 1]);
    $url = '/api/1.0/campaigns/1/entities/1/posts';

    $id = $this->postJson($url, [
        'name' => 'Tagged post', 'position' => 1, 'save_tags' => 1, 'tags' => [$tag->id],
        'calendar_id' => $calendar->id, 'calendar_day' => 4, 'calendar_year' => 1000,
    ])->assertCreated()
        ->assertJsonPath('data.tags', [$tag->id])
        ->assertJsonPath('data.calendar_id', $calendar->id)
        ->json('data.id');

    $this->putJson("$url/$id", ['name' => 'Omitted fields'])
        ->assertOk()
        ->assertJsonPath('data.tags', [$tag->id])
        ->assertJsonPath('data.calendar_id', $calendar->id);

    $this->putJson("$url/$id", ['name' => 'Cleared fields', 'save_tags' => 1, 'calendar_id' => null])
        ->assertOk()
        ->assertJsonPath('data.tags', [])
        ->assertJsonPath('data.calendar_id', null);
});

it('applies post form tags and reminders only to the post being saved', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $unrelated = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $tag = Tag::factory()->create(['campaign_id' => 1]);
    $post = Post::factory()->create(['entity_id' => $entity->id]);

    Post::saving(function () use ($unrelated) {
        $unrelated->update(['title' => 'Saved during the post request']);
    });

    $url = route('entities.posts.update', [1, $entity, $post]);
    $this->patch($url, [
        'name' => 'Updated post',
        'save_tags' => 1,
        'tags' => [$tag->id],
        'calendar_id' => $calendar->id,
        'calendar_day' => 4,
        'calendar_year' => 1000,
    ])->assertRedirect();

    expect($unrelated->fresh()->title)->toBe('Saved during the post request')
        ->and($unrelated->entity->fresh()->calendarReminder())->toBeNull()
        ->and($post->fresh()->tags->modelKeys())->toBe([$tag->id])
        ->and($post->fresh()->calendarReminder()?->calendar_id)->toBe($calendar->id);

    $this->patch($url, ['name' => 'Omitted fields'])->assertRedirect();
    $this->patch($url, ['name' => 'Skipped reminder', 'calendar_skip' => 1, 'calendar_id' => null])->assertRedirect();

    expect($post->fresh()->tags->modelKeys())->toBe([$tag->id])
        ->and($post->fresh()->calendarReminder()?->calendar_id)->toBe($calendar->id);

    $this->patch($url, ['name' => 'Cleared fields', 'save_tags' => 1, 'calendar_id' => null])->assertRedirect();

    expect($post->fresh()->tags)->toBeEmpty()
        ->and($post->fresh()->calendarReminder())->toBeNull();
});

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

it('does not update a post through another entity')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPosts()
    ->putJson('/api/1.0/campaigns/1/entities/2/posts/1', ['name' => 'Bob'])
    ->assertNotFound();

it('does not allow changing a post entity through the API', function () {
    $this->asUser()->withCampaign()->withCharacters()->withPosts();

    $this->putJson('/api/1.0/campaigns/1/entities/1/posts/1', [
        'name' => 'Bob',
        'entity_id' => 2,
    ])->assertSuccessful();

    expect(Post::findOrFail(1)->entity_id)->toBe(1);
});

it('saves a post when its entity has been soft deleted', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::findOrFail(1);
    $post = Post::factory()->create(['entity_id' => $entity->id]);
    $entity->delete();

    $post = Post::findOrFail($post->id);
    $post->update(['name' => 'Updated orphaned post']);

    expect($post->fresh()->name)->toBe('Updated orphaned post');
});

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
