<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config([
        'filesystems.default' => 's3',
    ]);
    Storage::fake('s3');
    $this->asUser()->withCampaign();
});

it('defaults to a dry run', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $source = 'images/' . $image->id . '/tiles/0/0/0.webp';
    $destination = $image->tilesPath() . '/0/0/0.webp';
    Storage::disk('s3')->put($source, 'tile');

    $this->artisan('images:move-map-tiles')
        ->expectsOutput('This is a dry run. Nothing will be moved.')
        ->assertSuccessful();

    Storage::disk('s3')->assertExists($source);
    Storage::disk('s3')->assertMissing($destination);
});

it('moves all tile files into the campaign-scoped image folder', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $source = 'images/' . $image->id . '/tiles';
    Storage::disk('s3')->put($source . '/0/0/0.webp', 'first-tile');
    Storage::disk('s3')->put($source . '/1/0/1.webp', 'second-tile');

    $this->artisan('images:move-map-tiles', ['--execute' => true])
        ->assertSuccessful();

    Storage::disk('s3')->assertMissing($source . '/0/0/0.webp');
    Storage::disk('s3')->assertMissing($source . '/1/0/1.webp');
    Storage::disk('s3')->assertExists($image->tilesPath() . '/0/0/0.webp');
    Storage::disk('s3')->assertExists($image->tilesPath() . '/1/0/1.webp');
});

it('leaves source files in place when a destination conflicts', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $source = 'images/' . $image->id . '/tiles/0/0/0.webp';
    $destination = $image->tilesPath() . '/0/0/0.webp';
    Storage::disk('s3')->put($source, 'old-tile');
    Storage::disk('s3')->put($destination, 'new-tile');

    $this->artisan('images:move-map-tiles', ['--execute' => true])
        ->assertFailed();

    Storage::disk('s3')->assertExists($source);
    expect(Storage::disk('s3')->get($destination))->toBe('new-tile');
});
