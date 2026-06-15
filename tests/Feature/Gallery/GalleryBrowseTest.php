<?php

use App\Models\User;

it('returns ext and size for images in browse results', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign()->withImages(['ext' => 'jpg', 'size' => 500]);

    $this->getJson('/w/test-campaign/gallery/browse')
        ->assertOk()
        ->assertJsonPath('images.0.ext', 'JPG')
        ->assertJsonPath('images.0.size', '500 KB');
});
