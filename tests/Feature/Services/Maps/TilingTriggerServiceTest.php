<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Services\Maps\TilingTriggerService;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->asUser()->withCampaign();
    Queue::fake();
});

it('triggers tiling for an oversized untiled image', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeTrue();
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->connection === 'heavy' && $job->image->id === $image->id);
});

it('does not trigger for an image below the threshold', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 50]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeFalse();
    expect($image->fresh()->tiling_status)->toBeNull();
    Queue::assertNotPushed(TileImageJob::class);
});

it('does not trigger twice for an image that is already tiled/running/errored', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200, 'tiling_status' => Image::TILING_FINISHED]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image);

    expect($triggered)->toBeFalse();
    Queue::assertNotPushed(TileImageJob::class);
});

it('force-triggers below the threshold when force is true (manual migrate/CLI path)', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 50]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image, force: true);

    expect($triggered)->toBeTrue();
    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->connection === 'heavy');
});

it('does not re-trigger an already-triggered image even when force is true', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200, 'tiling_status' => Image::TILING_RUNNING]);

    $triggered = app(TilingTriggerService::class)->maybeTrigger($image, force: true);

    expect($triggered)->toBeFalse();
    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertNotPushed(TileImageJob::class);
});
