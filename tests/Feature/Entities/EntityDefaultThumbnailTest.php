<?php

use Illuminate\Http\UploadedFile;

it('POSTS a new default thumbnail')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->postJson('/api/1.0/campaigns/1/default-thumbnails', [
        'entity_type' => 2,
        'default_entity_image' => UploadedFile::fake()->image('avatar.jpg')
    ])
    ->assertJsonFragment(["data" => "Default thumbnail succesfully uploaded"])
;

it('GETS all default thumbnails')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4, 'default_images' => ["characters" => "1"]])
    ->withImages()
    ->get('/api/1.0/campaigns/1/default-thumbnails')
    ->assertStatus(200)
;

it('DELETES a default thumbnail')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4, 'default_images' => ["characters" => "1"]])
    ->withImages()
    ->delete('/api/1.0/campaigns/1/default-thumbnails', ['entity_type' => 1])
    ->assertJsonFragment(["data" => "Default thumbnail succesfully deleted"])

;
