<?php

use App\Events\Maps\TilingChanged;
use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Event;

it('marks the image finished and broadcasts on successful tiling', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign()->withMaps()->withMapLayers();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);

    // Set the map layer to reference this image so event is dispatched
    MapLayer::first()->update(['image_uuid' => $image->id]);

    $this->mock(TilingService::class, function ($mock) {
        $mock->shouldReceive('tile')->once()->andReturn(['min_zoom' => 0, 'max_zoom' => 7]);
    });

    (new TileImageJob($image))->handle(app(TilingService::class));

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_FINISHED);
    expect($image->fresh()->tiling_error)->toBeNull();
    Event::assertDispatched(TilingChanged::class);
});

it('sets a permanent tiling error and broadcasts after exhausting retries', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign()->withMaps()->withMapLayers();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);

    // Set the map layer to reference this image so event is dispatched
    MapLayer::first()->update(['image_uuid' => $image->id]);

    (new TileImageJob($image))->failed(new Exception('vips exploded'));

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_ERROR);
    expect($image->fresh()->tiling_error)->toBe('vips exploded');
    Event::assertDispatched(TilingChanged::class);
});

it('retries three times with backoff before giving up', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1]);
    $job = new TileImageJob($image);

    expect($job->tries)->toBe(3);
    expect($job->backoff())->toBe([30, 60, 120]);
});

it('persists the real zoom range onto a map using this image, only if not already configured', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->mock(TilingService::class, function ($mock) {
        $mock->shouldReceive('tile')->once()->andReturn(['min_zoom' => 0, 'max_zoom' => 7]);
    });

    (new TileImageJob($image))->handle(app(TilingService::class));

    $map->refresh();
    expect($map->min_zoom)->toBe(0);
    expect($map->max_zoom)->toBe(7);
    expect($map->initial_zoom)->toBe(0);
});

it('does not overwrite a map\'s already-configured zoom range', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1, 'min_zoom' => 3, 'max_zoom' => 10]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->mock(TilingService::class, function ($mock) {
        $mock->shouldReceive('tile')->once()->andReturn(['min_zoom' => 0, 'max_zoom' => 7]);
    });

    (new TileImageJob($image))->handle(app(TilingService::class));

    $map->refresh();
    expect($map->min_zoom)->toBe(3);
    expect($map->max_zoom)->toBe(10);
});
