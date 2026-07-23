<?php

use App\Jobs\TileImageJob;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['maps.tiling_threshold_kb' => 100]);
    Queue::fake();
});

it('triggers tiling when a brand-new map\'s entity is created with an oversized gallery image already set', function () {
    // Build the Map row without firing its `created` event, so `ChildEntityObserver` doesn't
    // auto-create a bare Entity for it first. This mirrors what BaseEntityMapper/MoveService/
    // BulkService do: they set `image_uuid` on a not-yet-persisted `Entity` before its first save.
    $map = Map::factory()->make(['campaign_id' => 1]);
    $map->saveQuietly();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $entity = new Entity;
    $entity->entity_id = $map->id;
    $entity->name = $map->name;
    $entity->campaign_id = 1;
    $entity->type_id = config('entities.ids.map');
    $entity->is_private = false;
    $entity->image_uuid = $image->id;
    $entity->save();

    expect($entity->wasRecentlyCreated)->toBeTrue();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
});

it('triggers tiling when an existing map\'s entity is assigned a new oversized gallery image', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $map->entity->image_uuid = $image->id;
    $map->entity->save();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
});

it('does not trigger tiling for a non-map entity\'s image change', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $character->entity->image_uuid = $image->id;
    $character->entity->save();

    Queue::assertNotPushed(TileImageJob::class);
});

it('does not trigger tiling when a map\'s other fields are updated without an image change', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);

    $map->entity->name = 'Renamed';
    $map->entity->save();

    Queue::assertNotPushed(TileImageJob::class);
});
