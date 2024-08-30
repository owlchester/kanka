<?php

use Illuminate\Http\UploadedFile;

it('POSTS a new image')
    ->asUser(true)
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/images', [
        //'folder_id' => 1,
        'file' => [
            UploadedFile::fake()->image('avatar.jpg')
        ]
    ])
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'path'
            ]
        ]
    ])
;

it('GETS all images')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->get('/api/1.0/campaigns/1/images')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ]
        ]
    ])
;

it('GETS a specific image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->get('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ]
    ])
;

it('UPDATES a valid image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->putJson('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b', ['name' => 'bob', 'content' => 'content', 'is_enabled' => true])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'bob'])
;

it('DELETES a image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->delete('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b')
    ->assertStatus(204)
;

it('DELETES an invalid image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->delete('/api/1.0/campaigns/1/images/100')
    ->assertStatus(404)
;

it('cant GET a image as a player')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b')
    ->assertStatus(403)
;
