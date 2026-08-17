<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake();
    $this->asUser()->withCampaign();
});

it('moves the complete tile directory in one operation', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $source = 'images/' . $image->id . '/tiles';
    Storage::disk()->put($source . '/0/0/0.webp', 'first-tile');
    Storage::disk()->put($source . '/1/0/1.webp', 'second-tile');

    $this->artisan('images:move-map-tiles')
        ->assertSuccessful();

    Storage::disk()->assertMissing($source . '/0/0/0.webp');
    Storage::disk()->assertMissing($source . '/1/0/1.webp');
    Storage::disk()->assertExists($image->tilesPath() . '/0/0/0.webp');
    Storage::disk()->assertExists($image->tilesPath() . '/1/0/1.webp');
});

it('leaves the source directory in place when the destination exists', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $source = 'images/' . $image->id . '/tiles';
    $destination = $image->tilesPath();
    Storage::disk()->put($source . '/0/0/0.webp', 'old-tile');
    Storage::disk()->put($destination . '/0/0/0.webp', 'new-tile');

    $this->artisan('images:move-map-tiles')
        ->assertFailed();

    Storage::disk()->assertExists($source . '/0/0/0.webp');
    expect(Storage::disk()->get($destination . '/0/0/0.webp'))->toBe('new-tile');
});
