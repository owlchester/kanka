<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

it('deletes the tile folder when an image is deleted', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    Storage::put($image->tilesPath() . '/0/0_0.jpg', 'fake-tile-bytes');

    expect(Storage::exists($image->tilesPath() . '/0/0_0.jpg'))->toBeTrue();

    $image->delete();

    expect(Storage::exists($image->tilesPath() . '/0/0_0.jpg'))->toBeFalse();
});
