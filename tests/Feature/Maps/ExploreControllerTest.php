<?php

use App\Models\Image;
use App\Models\Map;

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
