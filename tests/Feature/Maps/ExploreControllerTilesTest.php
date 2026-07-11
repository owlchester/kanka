<?php

use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Storage;

it('serves a tile from the map\'s base image tiles folder', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    Storage::put($image->tilesPath() . '/3/2/1.jpg', 'fake-tile-bytes'); // z=3, y=2 (row), x=1 (col)

    $response = $this->get(route('maps.tiles', [1, $map->id]) . '?z=3&x=1&y=2');

    $response->assertRedirect(Storage::url($image->tilesPath() . '/3/2/1.jpg'));
});

it('serves a png tile when no jpg exists at that path (alpha-channel images)', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    Storage::put($image->tilesPath() . '/2/0/0.png', 'fake-png-tile-bytes');

    $response = $this->get(route('maps.tiles', [1, $map->id]) . '?z=2&x=0&y=0');

    $response->assertRedirect(Storage::url($image->tilesPath() . '/2/0/0.png'));
});

it('falls back to the transparent placeholder for a missing tile', function () {
    Storage::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('maps.tiles', [1, $map->id]) . '?z=3&x=1&y=2');

    $response->assertOk();
});

it('redirects the explore page with an error message while tiling is running, but not on permanent error', function () {
    $this->asUser()->withCampaign();
    $runningImage = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $runningMap = Map::factory()->create(['campaign_id' => 1, 'height' => 1000, 'width' => 1000]);
    $runningMap->entity->image_uuid = $runningImage->id;
    $runningMap->entity->saveQuietly();

    $this->get(route('maps.explore', [1, $runningMap->id]))
        ->assertRedirect(route('entities.show', [$runningMap->entity->campaign, $runningMap->entity]));

    $erroredImage = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $erroredMap = Map::factory()->create(['campaign_id' => 1, 'height' => 1000, 'width' => 1000]);
    $erroredMap->entity->image_uuid = $erroredImage->id;
    $erroredMap->entity->saveQuietly();

    $this->get(route('maps.explore', [1, $erroredMap->id]))->assertOk();
});
