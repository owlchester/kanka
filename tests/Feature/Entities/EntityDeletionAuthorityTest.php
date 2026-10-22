<?php

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Scopes\ActiveEntityScope;
use App\Services\Entity\ColumnDefinitionService;
use App\Services\Entity\PurgeService;
use App\Services\Entity\RecoveryService;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

dataset('deletion authority types', [
    'ability', 'attribute_template', 'calendar', 'character', 'conversation',
    'creature', 'dice_roll', 'event', 'family', 'item', 'journal', 'location',
    'map', 'note', 'organisation', 'quest', 'race', 'tag', 'timeline', 'whiteboard',
]);

function createDeletionAuthorityChild(string $type): MiscModel
{
    return app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail(config('entities.ids.' . $type)))
        ->create(['name' => 'Deletion authority']);
}

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['entities.ids.whiteboard' => EntityType::where('code', 'whiteboard')->value('id')]);
});

it('hides deleted entities from child queries without deleting child data', function (string $type) {
    $child = createDeletionAuthorityChild($type);
    $entity = $child->entity;
    $table = $child->getTable();

    expect(Schema::hasColumn($table, 'deleted_at'))->toBeFalse();

    $entity->delete();

    expect($entity->trashed())->toBeTrue()
        ->and($child::find($child->id))->toBeNull()
        ->and($child::count())->toBe(0)
        ->and(DB::table($table)->where('id', $child->id)->exists())->toBeTrue()
        ->and($child::withoutGlobalScope(ActiveEntityScope::class)->find($child->id))->not->toBeNull();

    $urls = app(RecoveryService::class)
        ->campaign(Campaign::findOrFail(1))
        ->user(auth()->user())
        ->recover([$entity->id]);

    expect($urls)->toHaveKey($entity->id)
        ->and($child::findOrFail($child->id)->entity->id)->toBe($entity->id);
})->with('deletion authority types');

it('permanently purges retained child rows when purging a deleted entity', function (string $type) {
    $child = createDeletionAuthorityChild($type);
    $entity = $child->entity;
    $entity->delete();

    $purge = app(PurgeService::class);
    $purge->trash(Entity::onlyTrashed()->findOrFail($entity->id));

    expect($purge->count())->toBe(1)
        ->and(DB::table($child->getTable())->where('id', $child->id)->exists())->toBeFalse()
        ->and(Entity::withTrashed()->find($entity->id))->toBeNull();
})->with('deletion authority types');

it('soft deletes only the entity through standard API delete endpoints', function (string $type) {
    $child = createDeletionAuthorityChild($type);
    $plural = $child->entity->entityType->pluralCode();
    $url = '/api/1.0/campaigns/1/' . $plural . '/' . $child->id;

    $this->deleteJson($url)->assertNoContent();

    expect(Entity::onlyTrashed()->find($child->entity->id))->not->toBeNull()
        ->and(DB::table($child->getTable())->where('id', $child->id)->exists())->toBeTrue();

    $this->getJson($url)->assertNotFound();
})->with([
    'ability', 'attribute_template', 'calendar', 'character', 'conversation',
    'creature', 'dice_roll', 'event', 'family', 'item', 'journal', 'location',
    'map', 'note', 'organisation', 'quest', 'race', 'tag', 'timeline',
]);

it('keeps deleted children out of relationship counts and eager loading', function () {
    $family = createDeletionAuthorityChild('family');
    $character = createDeletionAuthorityChild('character');
    $family->members()->attach($character->id);
    $character->entity->delete();

    $family = Family::with('members')->withCount('members')->findOrFail($family->id);

    expect($family->members_count)->toBe(0)
        ->and($family->members)->toBeEmpty();
});

it('excludes deleted entities from listing relationship counts', function (string $type) {
    $child = createDeletionAuthorityChild($type);
    $active = createDeletionAuthorityChild('character');
    $deleted = createDeletionAuthorityChild('character');

    foreach ([$active, $deleted] as $character) {
        if ($type === 'organisation') {
            $child->members()->create(['character_id' => $character->id]);
        } elseif ($type === 'family') {
            $child->members()->attach($character->id);
        } else {
            $child->entities()->attach($character->entity->id);
        }
    }
    $deleted->entity->delete();

    $counts = app(ColumnDefinitionService::class)->childCountRelations(
        $child->entity->entityType,
        Campaign::findOrFail(1),
    );
    $countColumn = in_array($type, ['organisation', 'family']) ? 'members_count' : 'entities_count';

    expect($child->newQuery()->withCount($counts)->findOrFail($child->id)->{$countColumn})->toBe(1);

    $this->getJson(route('entities.index-api', [1, $child->entity->entityType]))
        ->assertSuccessful()
        ->assertJsonPath('error', false)
        ->assertJsonPath('entities.data.0.' . $countColumn, 1);
})->with(['organisation', 'family', 'ability', 'tag']);

it('counts standalone quest elements but not elements linked to deleted entities', function () {
    $quest = createDeletionAuthorityChild('quest');
    $active = createDeletionAuthorityChild('character');
    $deleted = createDeletionAuthorityChild('character');
    $quest->elements()->create(['entity_id' => $active->entity->id]);
    $quest->elements()->create(['entity_id' => $deleted->entity->id]);
    $quest->elements()->create(['name' => 'Standalone element']);
    $deleted->entity->delete();

    $this->getJson(route('entities.index-api', [1, $quest->entity->entityType]))
        ->assertSuccessful()
        ->assertJsonPath('error', false)
        ->assertJsonPath('entities.data.0.elements_count', 2);
});

it('matches deletion state by entity type as well as child id', function () {
    $character = createDeletionAuthorityChild('character');
    $family = createDeletionAuthorityChild('family');
    expect($character->id)->toBe($family->id);
    $family->entity->delete();

    expect(Character::find($character->id))->not->toBeNull()
        ->and(Family::find($family->id))->toBeNull();
});

it('retains child rows and images when deleting through the web UI', function () {
    $child = createDeletionAuthorityChild('character');
    $entity = $child->entity;
    $entity->image_path = 'characters/retained.jpg';
    $entity->saveQuietly();
    Storage::disk('s3')->put($entity->image_path, 'image');

    $this->delete(route('entities.destroy', [1, $entity]))->assertRedirect();

    expect(Entity::onlyTrashed()->find($entity->id))->not->toBeNull()
        ->and(DB::table('characters')->where('id', $child->id)->exists())->toBeTrue();
    Storage::disk('s3')->assertExists('characters/retained.jpg');
});

it('checks API delete authorization before changing entity state', function () {
    $child = createDeletionAuthorityChild('character');
    Gate::before(fn ($user, string $ability) => $ability === 'delete' ? false : null);

    $this->deleteJson('/api/1.0/campaigns/1/characters/' . $child->id)->assertForbidden();

    expect(Character::find($child->id))->not->toBeNull();
});

it('detaches both active and deleted descendants before permanently purging their parent', function () {
    $parent = createDeletionAuthorityChild('character')->entity;
    $active = createDeletionAuthorityChild('character')->entity;
    $deleted = createDeletionAuthorityChild('character')->entity;
    $active->update(['parent_id' => $parent->id]);
    $deleted->update(['parent_id' => $parent->id]);
    $deleted->delete();
    $parent->delete();

    app(PurgeService::class)->trash($parent);

    expect(Entity::findOrFail($active->id)->parent_id)->toBeNull()
        ->and(Entity::onlyTrashed()->findOrFail($deleted->id)->parent_id)->toBeNull()
        ->and(CampaignLocalization::getConsoleCampaign())->toBe(0);
});

it('preserves campaign scoping when bypassing deletion filtering for cleanup', function () {
    $child = createDeletionAuthorityChild('character');
    CampaignLocalization::setConsoleCampaign(2);

    try {
        expect(Character::find($child->id))->toBeNull()
            ->and(Character::withoutGlobalScope(ActiveEntityScope::class)->find($child->id))->toBeNull();
    } finally {
        CampaignLocalization::setConsoleCampaign(0);
    }
});

it('restores current deletion state to child columns when rolling back', function () {
    $child = createDeletionAuthorityChild('character');
    $child->entity->delete();
    $schema = require database_path('migrations/2026_10_21_235313_drop_deleted_at_from_entity_children.php');
    $reconcile = require database_path('migrations/2026_10_21_235312_reconcile_entity_child_soft_deletions.php');

    $schema->down();
    $reconcile->down();

    expect(DB::table('characters')->where('id', $child->id)->value('deleted_at'))->toBe($child->entity->getRawOriginal('deleted_at'));

    $reconcile->up();
    $schema->up();

    expect(Character::find($child->id))->toBeNull()
        ->and(Schema::hasColumn('characters', 'deleted_at'))->toBeFalse();
});

it('reconciles child-only tombstones without overwriting existing entity deletion dates', function (string $type) {
    $schema = require database_path('migrations/2026_10_21_235313_drop_deleted_at_from_entity_children.php');
    $schema->down();
    $childOnly = createDeletionAuthorityChild($type);
    $both = createDeletionAuthorityChild($type);
    $entityOnly = createDeletionAuthorityChild($type);
    $active = createDeletionAuthorityChild($type);
    $childDate = now()->subDays(3)->startOfSecond();
    $entityDate = now()->subDays(7)->startOfSecond();
    $updatedAt = $childOnly->entity->getRawOriginal('updated_at');
    DB::table($childOnly->getTable())->whereIn('id', [$childOnly->id, $both->id])->update(['deleted_at' => $childDate]);
    DB::table('entities')->whereIn('id', [$both->entity->id, $entityOnly->entity->id])->update(['deleted_at' => $entityDate]);

    $reconcile = require database_path('migrations/2026_10_21_235312_reconcile_entity_child_soft_deletions.php');
    $reconcile->up();
    $schema->up();

    expect(Entity::onlyTrashed()->findOrFail($childOnly->entity->id)->deleted_at->equalTo($childDate))->toBeTrue()
        ->and(Entity::onlyTrashed()->findOrFail($childOnly->entity->id)->getRawOriginal('updated_at'))->toBe($updatedAt)
        ->and(Entity::onlyTrashed()->findOrFail($both->entity->id)->deleted_at->equalTo($entityDate))->toBeTrue()
        ->and(Entity::onlyTrashed()->findOrFail($entityOnly->entity->id)->deleted_at->equalTo($entityDate))->toBeTrue()
        ->and($active::find($active->id))->not->toBeNull()
        ->and($childOnly::find($childOnly->id))->toBeNull()
        ->and(Schema::hasColumn($childOnly->getTable(), 'deleted_at'))->toBeFalse()
        ->and(Schema::hasColumn((new Post)->getTable(), 'deleted_at'))->toBeTrue();
})->with('deletion authority types');
