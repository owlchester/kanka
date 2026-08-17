<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

it('builds the tiles storage path inside the campaign and keyed by image uuid', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);

    expect($image->tilesPath())->toBe('campaigns/1/tiles/' . $image->id);
});

it('serves legacy tiles until they have been migrated', function () {
    Storage::fake();
    config(['cdn.ugc' => 'https://cdn.example.test']);
    $this->actingAs(User::factory()->create());
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);
    Storage::disk()->put($image->legacyTilesPath() . '/0/0/0.webp', 'tile');

    expect($image->tilesUrlTemplate())
        ->toBe('https://cdn.example.test/' . $image->legacyTilesPath() . '/{z}/{y}/{x}.webp');
});

it('continues serving legacy tiles during migration', function () {
    Storage::fake();
    config(['cdn.ugc' => 'https://cdn.example.test']);
    $this->actingAs(User::factory()->create());
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);
    Storage::disk()->put($image->legacyTilesPath() . '/0/0/0.webp', 'legacy');
    Storage::disk()->put($image->tilesPath() . '/0/0/0.webp', 'migrated');

    expect($image->tilesUrlTemplate())
        ->toBe('https://cdn.example.test/' . $image->legacyTilesPath() . '/{z}/{y}/{x}.webp');
});

it('serves migrated tiles after the legacy directory is removed', function () {
    Storage::fake();
    config(['cdn.ugc' => 'https://cdn.example.test']);
    $this->actingAs(User::factory()->create());
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);
    Storage::disk()->put($image->tilesPath() . '/0/0/0.webp', 'migrated');

    expect($image->tilesUrlTemplate())
        ->toBe('https://cdn.example.test/' . $image->tilesPath() . '/{z}/{y}/{x}.webp');
});
