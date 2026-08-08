<?php

use App\Models\Character;
use App\Models\Image;
use Illuminate\Http\UploadedFile;

it('POSTS a new image')
    ->asUser(true)
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/images', [
        // 'folder_id' => 1,
        'file' => [
            UploadedFile::fake()->image('avatar.jpg'),
        ],
    ])
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'path',
                'version',
            ],
        ],
    ]);

it('uses versioned paths for new images', function () {
    $this->asUser(true)->withCampaign();

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'jpg']);

    expect($image->version)->toBe(1)
        ->and($image->path)->toBe('campaigns/1/' . $image->id . '/1.jpg');
});

it('keeps legacy paths for images without a version', function () {
    $this->asUser(true)->withCampaign();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'ext' => 'jpg',
        'version' => null,
    ]);

    expect($image->path)->toBe('campaigns/1/' . $image->id . '.jpg');

    $this->get('/api/1.0/campaigns/1/images/' . $image->id)
        ->assertSuccessful()
        ->assertJsonPath('data.version', 1);
});

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
            ],
        ],
    ]);

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
        ],
    ]);

it('UPDATES a valid image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->putJson('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b', ['name' => 'bob', 'content' => 'content', 'is_enabled' => true])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'bob']);

it('UPDATES and returns image description and author')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->putJson('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b', [
        'name' => 'portrait',
        'description' => '<b>Portrait description</b>',
        'author' => '<i>Artist</i>',
    ])
    ->assertSuccessful()
    ->assertJsonPath('data.description', 'Portrait description')
    ->assertJsonPath('data.author', 'Artist');

it('GETS image metadata for an entity avatar', function () {
    $this->asUser(true)->withCampaign()->withCharacters();

    $entity = Character::find(1)->entity;
    $image = Image::factory()->create([
        'campaign_id' => 1,
        'description' => 'Avatar description',
        'author' => 'Avatar artist',
    ]);
    $entity->update(['image_uuid' => $image->id]);

    $this->get('/api/1.0/campaigns/1/entities/1/image')
        ->assertSuccessful()
        ->assertJsonPath('data.image.description', 'Avatar description')
        ->assertJsonPath('data.image.author', 'Avatar artist');
});

it('DELETES a image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->delete('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b')
    ->assertStatus(204);

it('DELETES an invalid image')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->delete('/api/1.0/campaigns/1/images/100')
    ->assertStatus(404);

it('cant GET a image as a player')
    ->asUser(true)
    ->withCampaign()
    ->withImages()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/images/16598f1b-7d93-36d9-bea5-212bfa1e354b')
    ->assertStatus(403);
