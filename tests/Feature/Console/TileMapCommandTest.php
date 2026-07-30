<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

it('force-triggers tiling for a map\'s gallery image regardless of size', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])->assertSuccessful();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('fails gracefully for a map with no gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->artisan('maps:tile', ['map' => $map->id])->assertFailed();
});

it('fails gracefully for an unknown map id', function () {
    $this->asUser()->withCampaign();

    $this->artisan('maps:tile', ['map' => 999999])->assertFailed();
});

it('confirms before retrying a permanently-failed image, and retries when confirmed', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR, 'tiling_error' => 'vips exploded']);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])
        ->expectsConfirmation('Re-tile this image?', 'yes')
        ->assertSuccessful();

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('does not retry a permanently-failed image when the user declines', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR, 'tiling_error' => 'vips exploded']);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])
        ->expectsConfirmation('Re-tile this image?', 'no')
        ->assertSuccessful();

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_ERROR);
    Queue::assertNotPushed(TileImageJob::class);
});

it('confirms before re-tiling an already-tiled image, and re-tiles when confirmed', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])
        ->expectsConfirmation('Re-tile this image?', 'yes')
        ->assertSuccessful();

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('does not re-tile an already-tiled image when the user declines', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])
        ->expectsConfirmation('Re-tile this image?', 'no')
        ->assertSuccessful();

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_FINISHED);
    Queue::assertNotPushed(TileImageJob::class);
});

it('does not prompt and does not trigger for a currently-running image', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])->assertSuccessful();

    expect($image->fresh()->tiling_status)->toBe(Image::TILING_RUNNING);
    Queue::assertNotPushed(TileImageJob::class);
});
