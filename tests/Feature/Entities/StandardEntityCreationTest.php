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
        ->and($child->entity->name)->toBe('Factory-created name')
        ->and(Entity::count())->toBe($count + 1);
})->with('misc models');

it('dispatches creation completion once after linking the child with observers enabled', function () {
    Event::fake([EntityCreationCompleted::class]);
    $child = Character::factory()->create(['campaign_id' => 1]);

    Event::assertDispatchedTimes(EntityCreationCompleted::class, 1);
    Event::assertDispatched(EntityCreationCompleted::class, fn ($event) => $event->entity->entity_id === $child->id);
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
