<?php

use App\Facades\Images;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Image;
use App\Models\Map;
use App\Services\Entity\PurgeService;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

function createEntityWithLegacyImages(string $type): Entity
{
    if ($type === 'custom') {
        $entityType = new EntityType([
            'code' => 'custom_image_owner',
            'is_special' => true,
            'is_enabled' => true,
        ]);
        $entityType->campaign_id = 1;
        $entityType->icon = 'fa-solid fa-image';
        $entityType->singular = 'Image owner';
        $entityType->plural = 'Image owners';
        $entityType->save();
        $entity = new Entity(['name' => 'Custom image owner', 'campaign_id' => 1]);
        $entity->type_id = $entityType->id;
        $entity->save();
    } else {
        $class = $type === 'map' ? Map::class : Character::class;
        $entity = $class::factory()->create(['campaign_id' => 1])->entity;
    }

    $entity->image_path = 'legacy/' . $entity->id . '/portrait.jpg';
    $entity->header_image = 'legacy/' . $entity->id . '/header.jpg';
    $entity->saveQuietly();

    foreach ([$entity->image_path, $entity->header_image] as $path) {
        Storage::put($path, 'image');
        Storage::put(str_replace('.', '_thumb.', $path), 'thumbnail');
    }

    return $entity;
}

beforeEach(function () {
    $this->asUser()->withCampaign();
    Queue::fake();
});

it('retains entity image and header files during soft deletion and recovery', function (string $type) {
    $entity = createEntityWithLegacyImages($type);
    $paths = [$entity->image_path, $entity->header_image];

    $entity->delete();
    $entity->restore();

    foreach ($paths as $path) {
        Storage::assertExists($path);
        Storage::assertExists(str_replace('.', '_thumb.', $path));
    }
})->with(['character', 'map', 'custom']);

it('cleans entity-owned image and header files on force deletion', function (string $type, bool $trashed) {
    $entity = createEntityWithLegacyImages($type);
    $paths = [$entity->image_path, $entity->header_image];
    if ($trashed) {
        $entity->delete();
    }

    $entity->forceDelete();

    foreach ($paths as $path) {
        Storage::assertMissing($path);
        Storage::assertMissing(str_replace('.', '_thumb.', $path));
    }
})->with(['character', 'map', 'custom'])->with([true, false]);

it('cleans entity files during purge even when observers are disabled', function (string $type) {
    $entity = createEntityWithLegacyImages($type);
    $paths = [$entity->image_path, $entity->header_image];
    $entity->delete();

    Entity::withoutEvents(fn () => app(PurgeService::class)->trash($entity));

    foreach ($paths as $path) {
        Storage::assertMissing($path);
        Storage::assertMissing(str_replace('.', '_thumb.', $path));
    }
    expect(Entity::withTrashed()->find($entity->id))->toBeNull();
})->with(['character', 'map', 'custom']);

it('does not delete gallery images shared by other entities', function () {
    $entity = createEntityWithLegacyImages('character');
    $other = Character::factory()->create(['campaign_id' => 1])->entity;
    $image = Image::factory()->create(['campaign_id' => 1]);
    Storage::put($image->path, 'shared gallery image');
    $entity->forceFill(['image_uuid' => $image->id, 'header_uuid' => $image->id])->saveQuietly();
    $other->forceFill(['image_uuid' => $image->id])->saveQuietly();

    $entity->forceDelete();

    expect($image->fresh())->not->toBeNull()
        ->and($other->fresh()->image_uuid)->toBe($image->id);
    Storage::assertExists($image->path);
});

it('does not clean entity images when deleting a child row', function () {
    $entity = createEntityWithLegacyImages('character');
    $paths = [$entity->image_path, $entity->header_image];

    $entity->child->delete();

    foreach ($paths as $path) {
        Storage::assertExists($path);
    }
    expect($entity->fresh())->not->toBeNull();
});

it('retains entity images when transforming its child type', function () {
    $entity = createEntityWithLegacyImages('character');
    $paths = [$entity->image_path, $entity->header_image];

    $this->postJson('/api/1.0/campaigns/1/transform', [
        'entities' => [$entity->id],
        'entity_type' => config('entities.ids.organisation'),
    ])->assertSuccessful();

    expect($entity->fresh()->type_id)->toBe(config('entities.ids.organisation'));
    foreach ($paths as $path) {
        Storage::assertExists($path);
    }
});

it('allows repeated cleanup without needing a child model', function () {
    $entity = createEntityWithLegacyImages('map');
    $paths = [$entity->image_path, $entity->header_image];
    Entity::withoutEvents(fn () => $entity->forceDelete());

    Images::cleanupEntity($entity);
    Images::cleanupEntity($entity);

    foreach ($paths as $path) {
        Storage::assertMissing($path);
    }
    expect($entity->image_path)->toBeNull()
        ->and($entity->header_image)->toBeNull();
});

it('still resets map dimensions when removing an active entity image', function () {
    $entity = createEntityWithLegacyImages('map');
    $entity->map->forceFill(['height' => 100, 'width' => 200])->saveQuietly();

    Images::model($entity)->field('image')->cleanup();

    expect($entity->map->fresh()->height)->toBeNull()
        ->and($entity->map->fresh()->width)->toBeNull();
});
