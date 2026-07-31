<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('has no dimensions by default', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id]);

    expect($image->hasDimensions())->toBeFalse();
    expect($image->width())->toBeNull();
    expect($image->height())->toBeNull();
});

it('calculates raster dimensions from a partial image stream without downloading the full file', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);
    Storage::put($image->path, $pngBytes);

    expect($image->calculateDimensions())->toBe(['width' => 80, 'height' => 40]);
});

it('calculates svg dimensions from the root element attributes', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'svg']);

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="60"></svg>';
    Storage::put($image->path, $svg);

    expect($image->calculateDimensions())->toBe(['width' => 120, 'height' => 60]);
});

it('ensures dimensions get calculated and persisted only once', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);
    Storage::put($image->path, $pngBytes);

    $image->ensureDimensions();

    expect($image->width())->toBe(80);
    expect($image->height())->toBe(40);
    expect($image->fresh()->width())->toBe(80);

    // Deleting the file doesn't change anything: metadata is already cached, so
    // ensureDimensions() should not try (and fail) to recalculate.
    Storage::delete($image->path);
    $image->ensureDimensions();
    expect($image->width())->toBe(80);
});

it('never calculates dimensions for fonts', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'woff2']);

    $image->ensureDimensions();

    expect($image->hasDimensions())->toBeFalse();
});

it('caches a zeroed result instead of crashing when the file is missing from storage', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    // No file is ever put into storage for this image.
    $image->ensureDimensions();

    expect($image->hasDimensions())->toBeTrue();
    expect($image->width())->toBe(0);
    expect($image->height())->toBe(0);
});

it('only recalculates a missing-file image once, thanks to the cached zeroed result', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    $image->ensureDimensions();
    expect($image->fresh()->hasDimensions())->toBeTrue();

    // Calling it again should not throw or change anything, since the result is
    // already cached in metadata.
    $image->ensureDimensions();
    expect($image->width())->toBe(0);
    expect($image->height())->toBe(0);
});
