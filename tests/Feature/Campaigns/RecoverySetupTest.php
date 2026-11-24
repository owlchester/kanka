<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

it('returns deleted entities and posts with deleter, type, icon, parent, and expiration metadata', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $user = auth()->user();

    $deletedCharacter = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Deleted Hero',
    ])->entity;

    $activeParent = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Active Parent',
    ])->entity;

    $deletedPost = Post::factory()->create([
        'entity_id' => $activeParent->id,
        'name' => 'Lost Note',
    ]);

    $deletedAt = now()->subDays(2);
    $postDeletedAt = now()->subDays(1);

    DB::table('entities')
        ->where('id', $deletedCharacter->id)
        ->update([
            'deleted_at' => $deletedAt->toDateTimeString(),
            'deleted_by' => $user->id,
        ]);

    DB::table('posts')
        ->where('id', $deletedPost->id)
        ->update([
            'deleted_at' => $postDeletedAt->toDateTimeString(),
            'deleted_by' => $user->id,
        ]);

    $response = $this->getJson(route('recovery.setup', 1))
        ->assertOk();

    $elements = collect($response->json('elements'));
    expect($elements)->toHaveCount(2);

    $postElement = $elements->firstWhere('type', 'post');
    expect($postElement)->not->toBeNull()
        ->and($postElement['id'])->toBe($deletedPost->id)
        ->and($postElement['name'])->toBe('Lost Note')
        ->and($postElement['parent_name'])->toBe('Active Parent')
        ->and($postElement['deleted_by'])->toBe($user->id)
        ->and($postElement['deleted_name'])->toBe($user->name)
        ->and($postElement['type_id'])->toBe(0)
        ->and($postElement['type_name'])->toBe(__('entities.article'))
        ->and($postElement['icon'])->toBe('fa-duotone fa-pen')
        ->and($postElement['deleted_at_formatted'])->toBe($postDeletedAt->toDateTimeString())
        ->and($postElement['deleted_at_timestamp'])->toBe($postDeletedAt->timestamp)
        ->and($postElement['days_left'])->toBeInt()
        ->and($postElement['expires_label'])->toBeString()->not->toBeEmpty()
        ->and($postElement['expires_tooltip'])->toBeString()->not->toBeEmpty();

    $entityElement = $elements->firstWhere('type', 'entity');
    expect($entityElement)->not->toBeNull()
        ->and($entityElement['id'])->toBe($deletedCharacter->id)
        ->and($entityElement['name'])->toBe('Deleted Hero')
        ->and($entityElement['parent_name'])->toBeNull()
        ->and($entityElement['deleted_by'])->toBe($user->id)
        ->and($entityElement['deleted_name'])->toBe($user->name)
        ->and($entityElement['type_id'])->toBe($deletedCharacter->type_id)
        ->and($entityElement['type_name'])->toBeString()->not->toBeEmpty()
        ->and($entityElement['icon'])->toBeString()->not->toBeEmpty()
        ->and($entityElement['deleted_at_formatted'])->toBe($deletedAt->toDateTimeString())
        ->and($entityElement['deleted_at_timestamp'])->toBe($deletedAt->timestamp)
        ->and($entityElement['days_left'])->toBeInt()
        ->and($entityElement['expires_label'])->toBeString()->not->toBeEmpty()
        ->and($entityElement['expires_tooltip'])->toBeString()->not->toBeEmpty();
});

it('resolves deleted_name for former or external users and falls back to unknown when deleted_by is null', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $externalUser = User::factory()->create(['name' => 'Former Member']);

    $byExternal = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'External Deleted',
    ])->entity;

    $byUnknown = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Unknown Deleted',
    ])->entity;

    DB::table('entities')->where('id', $byExternal->id)->update([
        'deleted_at' => now()->subHours(2)->toDateTimeString(),
        'deleted_by' => $externalUser->id,
    ]);

    DB::table('entities')->where('id', $byUnknown->id)->update([
        'deleted_at' => now()->subHours(3)->toDateTimeString(),
        'deleted_by' => null,
    ]);

    $elements = collect($this->getJson(route('recovery.setup', 1))->assertOk()->json('elements'));

    $externalRow = $elements->firstWhere('id', $byExternal->id);
    expect($externalRow['deleted_by'])->toBe($externalUser->id)
        ->and($externalRow['deleted_name'])->toBe('Former Member');

    $unknownRow = $elements->firstWhere('id', $byUnknown->id);
    expect($unknownRow['deleted_by'])->toBeNull()
        ->and($unknownRow['deleted_name'])->toBe(__('crud.history.unknown'));
});

it('excludes deleted posts whose parent entity is also deleted and excludes other campaigns', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);

    $deletedParent = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Deleted Parent',
    ])->entity;

    $postUnderDeletedParent = Post::factory()->create([
        'entity_id' => $deletedParent->id,
        'name' => 'Hidden Child Post',
    ]);

    DB::table('entities')->where('id', $deletedParent->id)->update([
        'deleted_at' => now()->subDay()->toDateTimeString(),
    ]);
    DB::table('posts')->where('id', $postUnderDeletedParent->id)->update([
        'deleted_at' => now()->subHours(5)->toDateTimeString(),
    ]);

    $otherCampaign = Campaign::factory()->create();
    $otherEntity = Character::factory()->create([
        'campaign_id' => $otherCampaign->id,
        'name' => 'Other Campaign Entity',
    ])->entity;
    DB::table('entities')->where('id', $otherEntity->id)->update([
        'deleted_at' => now()->subHour()->toDateTimeString(),
    ]);

    $elements = collect($this->getJson(route('recovery.setup', 1))->assertOk()->json('elements'));

    expect($elements)->toHaveCount(1)
        ->and($elements->first()['type'])->toBe('entity')
        ->and($elements->first()['id'])->toBe($deletedParent->id);
});
