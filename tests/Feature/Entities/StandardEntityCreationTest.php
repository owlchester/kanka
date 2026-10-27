<?php

use App\Events\Entities\EntityCreationCompleted;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Item;
use App\Models\Location;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['entities.ids.whiteboard' => EntityType::where('code', 'whiteboard')->value('id')]);
});

it('creates and links a child without model observers', function (string $modelClass) {
    Event::fake([EntityCreationCompleted::class]);
    $count = Entity::count();

    $child = Model::withoutEvents(fn () => app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail((new $modelClass)->entityTypeId()))
        ->create(['name' => 'Service-created name']));

    $this->assertModelExists($child);
    expect($child->entity->fresh()->entity_id)->toBe($child->id)
        ->and($child->entity->child_type)->toBe($child::class)
        ->and($child->fresh()->entity->name)->toBe('Service-created name')
        ->and(Entity::count())->toBe($count + 1);
    Event::assertDispatchedTimes(EntityCreationCompleted::class, 1);
})->with('misc models');

it('persists factory entities without model observers', function (string $modelClass) {
    $count = Entity::count();
    $child = $modelClass::factory()->createQuietly([
        'campaign_id' => 1,
        'name' => 'Factory-created name',
    ]);

    expect($child->fresh()->entity->entity_id)->toBe($child->id)
        ->and($child->entity->child_type)->toBe($child::class)
        ->and($child->entity->name)->toBe('Factory-created name')
        ->and(Entity::count())->toBe($count + 1);
})->with('misc models');

it('dispatches creation completion once after linking the child with observers enabled', function () {
    Event::fake([EntityCreationCompleted::class]);
    $child = Character::factory()->create(['campaign_id' => 1]);

    Event::assertDispatchedTimes(EntityCreationCompleted::class, 1);
    Event::assertDispatched(EntityCreationCompleted::class, fn ($event) => $event->entity->entity_id === $child->id);
});

it('resolves child and inverse entity through polymorphic relations', function () {
    $child = Character::factory()->create(['campaign_id' => 1]);
    $entity = Entity::with('child')->findOrFail($child->entity->id);

    expect($entity->child)->toBeInstanceOf(Character::class)
        ->and($entity->child->is($child))->toBeTrue()
        ->and($child->fresh()->entity->is($entity))->toBeTrue();
});

it('migrates existing child class names without changing timestamps', function (string $modelClass) {
    $child = $modelClass::factory()->create(['campaign_id' => 1]);
    $entity = $child->entity;
    $timestamps = DB::table('entities')->where('id', $entity->id)->first(['created_at', 'updated_at']);
    DB::table('entities')->where('id', $entity->id)->update(['child_type' => null]);

    $migration = require database_path('migrations/2026_10_27_231450_backfill_entity_child_types.php');
    $migration->up();
    $migration->up();

    expect($entity->fresh()->child_type)->toBe($modelClass)
        ->and($child->fresh()->entity->id)->toBe($entity->id)
        ->and($entity->fresh()->getRawOriginal('created_at'))->toBe($timestamps->created_at)
        ->and($entity->fresh()->getRawOriginal('updated_at'))->toBe($timestamps->updated_at);
})->with('misc models');

it('bulk migrates deleted entities and preserves populated discriminators', function () {
    $child = Character::factory()->create(['campaign_id' => 1]);
    $entity = $child->entity;
    $attributes = $entity->getAttributes();
    unset($attributes['id']);
    $attributes['child_type'] = null;
    $attributes['deleted_at'] = now()->toDateTimeString();

    foreach (array_chunk(array_fill(0, 1001, $attributes), 100) as $rows) {
        DB::table('entities')->insert($rows);
    }
    DB::table('entities')->where('id', $entity->id)->update(['child_type' => Location::class]);

    $migration = require database_path('migrations/2026_10_27_231450_backfill_entity_child_types.php');
    $migration->up();

    expect(DB::table('entities')->where('type_id', $entity->type_id)->whereNull('child_type')->count())->toBe(0)
        ->and(DB::table('entities')->whereNotNull('deleted_at')->where('child_type', Character::class)->count())->toBe(1001)
        ->and($entity->fresh()->child_type)->toBe(Location::class);
});

it('only backfills supported standard categories including incomplete child pointers', function () {
    $child = Character::factory()->create(['campaign_id' => 1]);
    $entity = $child->entity;
    DB::table('entities')->where('id', $entity->id)->update(['child_type' => null, 'entity_id' => null]);

    $customType = new EntityType([
        'code' => 'character',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $customType->campaign_id = 1;
    $customType->icon = 'fa-solid fa-user';
    $customType->save();

    $attributes = $entity->fresh()->getAttributes();
    unset($attributes['id']);
    $attributes['type_id'] = $customType->id;
    $customId = DB::table('entities')->insertGetId($attributes);
    $attributes['type_id'] = config('entities.ids.bookmark');
    $bookmarkId = DB::table('entities')->insertGetId($attributes);

    $migration = require database_path('migrations/2026_10_27_231450_backfill_entity_child_types.php');
    $migration->up();
    $migration->down();

    expect($entity->fresh()->child_type)->toBe(Character::class)
        ->and(DB::table('entities')->where('id', $customId)->value('child_type'))->toBeNull()
        ->and(DB::table('entities')->where('id', $bookmarkId)->value('child_type'))->toBeNull();
});

it('does not persist entities when making factory models', function () {
    $count = Entity::count();
    $child = Character::factory()->make(['campaign_id' => 1, 'name' => 'Unsaved']);

    expect($child->exists)->toBeFalse()
        ->and($child->name)->toBe('Unsaved')
        ->and(Entity::count())->toBe($count);
});

it('preserves factory relationships and callbacks through service creation', function () {
    $location = Location::factory()
        ->has(Item::factory()->state(['campaign_id' => 1]), 'items')
        ->afterCreating(function (Location $location): void {
            expect($location->entity->fresh()->entity_id)->toBe($location->id);
        })
        ->create(['campaign_id' => 1]);

    expect($location->items)->toHaveCount(1)
        ->and($location->items->first()->entity->entity_id)->toBe($location->items->first()->id);
});

it('does not create an entity implicitly when saving a child', function () {
    $count = Entity::count();
    $child = new Character(['campaign_id' => 1]);
    $child->save();

    expect(Entity::count())->toBe($count)
        ->and(method_exists($child, 'createEntity'))->toBeFalse();
});

it('rolls back the entity if saving its child fails', function () {
    $child = Mockery::mock(Character::class)->makePartial();
    $child->shouldReceive('save')->once()->andThrow(new RuntimeException('Child save failed'));
    $count = Entity::count();

    expect(fn () => app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail(config('entities.ids.character')))
        ->create(['name' => 'Failed child'], $child))
        ->toThrow(RuntimeException::class, 'Child save failed');

    expect(Entity::count())->toBe($count);
});
