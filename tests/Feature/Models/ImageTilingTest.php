<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;

it('is not tiled by default', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingRunning())->toBeFalse();
    expect($image->tilingError())->toBeFalse();
    expect($image->tilingReady())->toBeTrue();
});

it('reports running state and blocks readiness while tiling', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'tiling_status' => Image::TILING_RUNNING]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingRunning())->toBeTrue();
    expect($image->tilingReady())->toBeFalse();
});

it('reports tiled true only once finished', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'tiling_status' => Image::TILING_FINISHED]);

    expect($image->isTiled())->toBeTrue();
    expect($image->tilingReady())->toBeTrue();
});

it('treats a permanent tiling error as ready (fallback to plain rendering), not tiled', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'tiling_status' => Image::TILING_ERROR]);

    expect($image->isTiled())->toBeFalse();
    expect($image->tilingError())->toBeTrue();
    expect($image->tilingReady())->toBeTrue();
});

it('builds the tiles storage path keyed by image uuid', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);

    expect($image->tilesPath())->toBe('images/' . $image->id . '/tiles');
});
