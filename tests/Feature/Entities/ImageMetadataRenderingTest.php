<?php

use App\Models\Character;
use App\Models\Image;

it('uses gallery image description for entity avatar alt text and shows its credit', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Character::find(1)->entity;
    $entity->name = 'Target Character';
    $entity->save();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'description' => 'Target portrait',
        'author' => 'Artist',
    ]);
    $entity->update(['image_uuid' => $image->id]);

    $this->get('/w/test-campaign/entities/' . $entity->id)
        ->assertSuccessful()
        ->assertSee('alt="Target portrait"', false)
        ->assertSee('Target portrait')
        ->assertSee('Credit: Artist');
});
