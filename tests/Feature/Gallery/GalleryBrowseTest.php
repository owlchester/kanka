<?php

use App\Models\User;

it('returns ext and size for images in browse results', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign()->withImages();

    $this->actingAs($user)
        ->getJson('/w/test-campaign/gallery/browse')
        ->assertOk()
        ->assertJsonPath('images.0.ext', 'PNG')
        ->assertJsonPath('images.0.size', '209 KB');
});
