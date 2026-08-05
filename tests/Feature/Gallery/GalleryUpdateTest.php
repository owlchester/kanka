<?php

use App\Models\Image;

it('updates and sanitizes image description and author')
    ->asUser()
    ->withCampaign()
    ->withImages()
    ->postJson('/w/test-campaign/gallery/16598f1b-7d93-36d9-bea5-212bfa1e354b/update', [
        'name' => 'portrait',
        'description' => '  <b>Portrait description</b>  ',
        'author' => '  <i>Artist</i>  ',
    ])
    ->assertSuccessful()
    ->assertJsonPath('data.description', 'Portrait description')
    ->assertJsonPath('data.author', 'Artist');

it('allows clearing image description and author', function () {
    $this->asUser()
        ->withCampaign()
        ->withImages(['description' => 'Existing description', 'author' => 'Existing author'])
        ->postJson('/w/test-campaign/gallery/16598f1b-7d93-36d9-bea5-212bfa1e354b/update', [
            'name' => 'portrait',
            'description' => '',
            'author' => '',
        ])
        ->assertSuccessful();

    expect(Image::find('16598f1b-7d93-36d9-bea5-212bfa1e354b'))
        ->description->toBeNull()
        ->author->toBeNull();
});
