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

it('returns zeroed dimensions instead of fataling on a malformed svg', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'svg']);

    Storage::put($image->path, '<svg xmlns="http://www.w3.org/2000/svg" width="120"');

    expect($image->calculateDimensions())->toBe(['width' => 0, 'height' => 0]);
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

it('does not cache anything when the file is missing from storage, so a later call can retry', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    // No file is ever put into storage for this image: this is meant to be transient
    // (S3 blip, upload race), so it must not get permanently cached as {0,0}.
    $image->ensureDimensions();

    expect($image->hasDimensions())->toBeFalse();
    expect($image->fresh()->hasDimensions())->toBeFalse();

    // Once the file actually shows up, a later call successfully calculates and
    // caches the real dimensions - proving the earlier missing-file call didn't
    // poison metadata.
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
});

it('permanently caches a zeroed result for a file that exists but fails to parse', function () {
    Storage::fake('s3');
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);

    // The file exists, but its bytes aren't a valid image - a permanent failure,
    // unlike a missing file, so the {0,0} result should be cached to avoid repeated
    // Storage reads.
    Storage::put($image->path, 'not a real image');

    $image->ensureDimensions();

    expect($image->hasDimensions())->toBeTrue();
    expect($image->width())->toBe(0);
    expect($image->height())->toBe(0);
    expect($image->fresh()->hasDimensions())->toBeTrue();

    // Deleting the file doesn't change anything: metadata is already cached, so
    // ensureDimensions() should not try (and fail) to recalculate.
    Storage::delete($image->path);
    $image->ensureDimensions();
    expect($image->width())->toBe(0);
    expect($image->height())->toBe(0);
});
