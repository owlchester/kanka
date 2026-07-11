<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['maps.tiling_threshold_kb' => 100]);
    Queue::fake();
});

it('triggers tiling when a new map layer is created with an oversized image', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('triggers tiling when an existing layer\'s image is changed', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $layer->image_uuid = $image->id;
    $layer->save();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('does not trigger tiling when a layer is updated without an image change', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);
    Queue::fake(); // reset after the create() above already triggered one dispatch

    $layer->name = 'Renamed layer';
    $layer->save();

    Queue::assertNotPushed(TileImageJob::class);
});
