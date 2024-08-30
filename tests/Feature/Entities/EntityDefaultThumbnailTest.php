<?php

use Illuminate\Http\UploadedFile;

it('POSTS a new default thumbnail')
    ->asUser(true)
    ->withCampaign(['boost_count' => 1])
    ->postJson('/api/1.0/campaigns/1/default-thumbnails', [
        'entity_type_id' => 2,
        'default_entity_image' => UploadedFile::fake()->image('avatar.jpg')
    ])
    ->assertJsonFragment(["data" => "Default thumbnail successfully uploaded"])
;

it('GETS all default thumbnails')
    ->asUser(true)
    ->withCampaign(['boost_count' => 1, 'default_images' => ["characters" => "16598f1b-7d93-36d9-bea5-212bfa1e354b"]])
    ->withImages()
    ->get('/api/1.0/campaigns/1/default-thumbnails')
    ->assertStatus(200)
;

it('DELETES a default thumbnail')
    ->asUser(true)
    ->withCampaign(['boost_count' => 1, 'default_images' => ["characters" => "16598f1b-7d93-36d9-bea5-212bfa1e354b"]])
    ->withImages()
    ->delete('/api/1.0/campaigns/1/default-thumbnails', ['entity_type_id' => 1])
    ->assertJsonFragment(["data" => "Default thumbnail successfully deleted"])
;
