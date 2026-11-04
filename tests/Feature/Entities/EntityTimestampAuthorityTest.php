<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Models\Post;
use App\Services\Caches\CharacterCacheService;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Support\Facades\Schema;

dataset('entity child types', [
    'ability', 'attribute_template', 'calendar', 'character', 'conversation',
    'creature', 'dice_roll', 'event', 'family', 'item', 'journal', 'location',
    'map', 'note', 'organisation', 'quest', 'race', 'tag', 'timeline', 'whiteboard',
]);

function createTimestampAuthorityChild(string $type, string $name = 'Timestamp authority'): MiscModel
{
    return app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail(config('entities.ids.' . $type)))
        ->create(['name' => $name]);
}

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['entities.ids.whiteboard' => EntityType::where('code', 'whiteboard')->value('id')]);
    $this->travelTo(now()->startOfSecond());
});

it('stores timestamps only on the entity and preserves serialized dates', function (string $type) {
    $child = createTimestampAuthorityChild($type);

    expect(Schema::hasColumn($child->getTable(), 'created_at'))->toBeFalse()
        ->and(Schema::hasColumn($child->getTable(), 'updated_at'))->toBeFalse()
        ->and(Schema::hasColumn($child->getTable(), 'deleted_at'))->toBeFalse()
        ->and($child->usesTimestamps())->toBeFalse()
        ->and($child->getAttributes())->not->toHaveKeys(['created_at', 'updated_at'])
        ->and($child->toArray())->not->toHaveKeys(['created_at', 'updated_at']);

    expect(Schema::hasColumn((new Post)->getTable(), 'updated_at'))->toBeTrue();
})->with('entity child types');

it('keeps API synchronization and child-only edits working', function (string $type, string $plural, string $field, mixed $value) {
    $child = createTimestampAuthorityChild($type);
    $this->travel(1)->hour();
    $lastSync = now()->toDateTimeString();
    $this->travel(1)->hour();

    $this->putJson('/api/1.0/campaigns/1/' . $plural . '/' . $child->id, [
        'name' => $child->name,
        $field => $value,
    ])->assertSuccessful();

    $response = $this->getJson('/api/1.0/campaigns/1/' . $plural . '?' . http_build_query(['lastSync' => $lastSync]));

    $response->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $child->id);

    expect($child->fresh()->entity->updated_at->equalTo(now()))->toBeTrue();
})->with([
    ['character', 'characters', 'title', 'Updated title'],
    ['location', 'locations', 'title', 'Updated title'],
    ['family', 'families', 'name', 'Updated family'],
    ['event', 'events', 'date', 'Tomorrow'],
    ['timeline', 'timelines', 'name', 'Updated timeline'],
    ['map', 'maps', 'is_real', true],
    ['quest', 'quests', 'name', 'Updated quest'],
]);

it('preserves entity timestamps during stealth edits of child fields', function () {
    $child = createTimestampAuthorityChild('character');
    $originalUpdatedAt = $child->entity->updated_at->copy();
    $this->travel(1)->hour();

    $this->patch(route('entities.update', [1, $child->entity]), [
        'name' => $child->name,
        'title' => 'Stealth title',
        'stealth' => 1,
    ])->assertRedirect();

    expect($child->fresh()->title)->toBe('Stealth title')
        ->and($child->fresh()->entity->updated_at->equalTo($originalUpdatedAt))->toBeTrue();
});

it('orders character suggestions by entity creation dates', function () {
    $older = createTimestampAuthorityChild('character');
    $older->update(['sex' => 'Older gender', 'pronouns' => 'Older pronouns']);
    $this->travel(1)->hour();
    $newer = createTimestampAuthorityChild('character');
    $newer->update(['sex' => 'Newer gender', 'pronouns' => 'Newer pronouns']);

    $cache = app(CharacterCacheService::class)->campaign(Campaign::findOrFail(1))->clearSuggestion();

    expect($cache->genderSuggestion())->toBe(['Newer gender', 'Older gender'])
        ->and($cache->pronounSuggestion())->toBe(['Newer pronouns', 'Older pronouns']);
});

it('can roll back and reapply the timestamp schema without altering entity dates', function () {
    $child = createTimestampAuthorityChild('character');
    $entityDates = $child->entity->only('created_at', 'updated_at');
    $migration = require database_path('migrations/2026_10_21_224802_drop_timestamps_from_entity_children.php');

    $migration->down();

    expect(Schema::hasColumn('characters', 'created_at'))->toBeTrue()
        ->and(Schema::hasColumn('characters', 'updated_at'))->toBeTrue();

    $migration->up();

    expect(Schema::hasColumn('characters', 'created_at'))->toBeFalse()
        ->and(Schema::hasColumn('characters', 'updated_at'))->toBeFalse()
        ->and(Character::findOrFail($child->id)->entity->only('created_at', 'updated_at'))->toEqual($entityDates);
});

it('updates entity timestamps on child saves including quiet saves', function (string $type, bool $quiet) {
    $child = createTimestampAuthorityChild($type);
    $originalCreatedAt = $child->entity->created_at->copy();
    $this->travel(1)->hour();

    $child->name = 'Changed child';
    $quiet ? $child->saveQuietly() : $child->save();
    $child->refresh();

    expect($child->entity->updated_at->equalTo(now()))->toBeTrue()
        ->and($child->entity->created_at->equalTo($originalCreatedAt))->toBeTrue();
})->with('entity child types')->with([true, false]);

it('forwards explicit and quiet timestamp touches to the entity', function (string $type, bool $quiet) {
    $child = createTimestampAuthorityChild($type);
    $this->travel(1)->hour();

    expect($quiet ? $child->entity->touchSilently() : $child->entity->touch())->toBeTrue();

    expect($child->fresh()->entity->updated_at->equalTo(now()))->toBeTrue();
})->with('entity child types')->with([true, false]);

it('uses entity timestamps for synchronization and recent ordering', function (string $type) {
    $older = createTimestampAuthorityChild($type, 'Older');
    $this->travel(1)->hour();
    $lastSync = now()->toDateTimeString();
    $this->travel(1)->hour();
    $newer = createTimestampAuthorityChild($type, 'Newer');
    $class = $older::class;

    expect($class::lastSync($lastSync)->pluck($older->qualifyColumn('id'))->all())->toBe([$newer->id])
        ->and($class::recent()->pluck($older->qualifyColumn('id'))->all())->toBe([$newer->id, $older->id]);
})->with('entity child types');

it('does not serialize entity timestamps as child attributes', function (string $type) {
    $child = createTimestampAuthorityChild($type);
    if (! method_exists($child, 'export')) {
        $this->markTestSkipped('This entity type does not expose child exports.');
    }

    $data = json_decode($child->export(), true, flags: JSON_THROW_ON_ERROR);

    expect($data)->not->toHaveKeys(['created_at', 'updated_at']);
})->with('entity child types');

it('keeps soft deletion and restoration working without child timestamps', function (string $type) {
    $child = createTimestampAuthorityChild($type);
    $child->entity->delete();

    expect($child::find($child->id))->toBeNull()
        ->and($child->entity()->withTrashed()->firstOrFail()->trashed())->toBeTrue();

    $child->entity()->withTrashed()->firstOrFail()->restore();

    expect($child->fresh())->not->toBeNull()
        ->and($child->fresh()->entity)->not->toBeNull();
})->with('entity child types');
