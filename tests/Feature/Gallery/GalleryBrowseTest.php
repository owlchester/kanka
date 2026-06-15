<?php

use App\Models\Image;
use App\Models\User;

it('returns ext and size for images in browse results', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign()->withImages(['ext' => 'jpg', 'size' => 500]);

    $this->getJson('/w/test-campaign/gallery/browse')
        ->assertOk()
        ->assertJsonPath('images.0.ext', 'JPG')
        ->assertJsonPath('images.0.size', '500 KB')
        ->assertJsonPath('images.0.image_count', null);
});

it('returns image_count for folder entries', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign();

    $folder = Image::factory()->create([
        'campaign_id' => 1,
        'is_folder' => true,
        'is_default' => false,
    ]);
    Image::factory()->count(3)->create([
        'campaign_id' => 1,
        'is_folder' => false,
        'is_default' => false,
        'folder_id' => $folder->id,
    ]);

    $this->getJson('/w/test-campaign/gallery/browse')
        ->assertOk()
        ->assertJsonPath('images.0.folder', true)
        ->assertJsonPath('images.0.image_count', 3);
});
