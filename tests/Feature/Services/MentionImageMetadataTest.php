<?php

use App\Models\Character;
use App\Models\Image;

it('returns the gallery image description for entity mention avatars', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $target = Character::find(1)->entity;
    $target->name = 'Target Character';
    $target->save();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'description' => 'Target portrait',
    ]);
    $target->update(['image_uuid' => $image->id]);

    $this->postJson('/w/test-campaign/search/mention', ['entities' => [$target->id]])
        ->assertSuccessful()
        ->assertJsonPath('0.image_alt', 'Target portrait');
});

it('returns the gallery image description in document mentions', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $target = Character::find(1)->entity;
    $target->name = 'Target Character';
    $target->save();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'description' => 'Target portrait',
    ]);
    $target->update(['image_uuid' => $image->id]);

    $source = Character::find(2)->entity;
    $source->entry = '[character:' . $target->id . ']';
    $source->save();

    $this->getJson('/w/test-campaign/entities/' . $source->id . '/api/document')
        ->assertSuccessful()
        ->assertJsonPath('mentions.0.image_alt', 'Target portrait');
});
