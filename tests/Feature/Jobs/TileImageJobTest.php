<?php

use App\Events\Maps\TilingChanged;
use App\Jobs\TileImageJob;
use App\Models\Image;
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
        $mock->shouldReceive('tile')->once();
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
