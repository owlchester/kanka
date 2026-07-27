<?php

use App\Enums\EntityAssetType;
use App\Models\EntityAsset;
use Illuminate\Http\UploadedFile;

it('POSTS an invalid entity_assets form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [])
    ->assertStatus(422);

it('POSTS a new Alias')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'entity_id' => 1,
        'type_id' => 3,
        'visibility_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('POSTS a new File')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        // 'entity_id' => 1,
        'type_id' => 1,
        'visibility_id' => 1,
        'file' => UploadedFile::fake()->image('avatar.jpg'),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('POSTS a new Link')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'entity_id' => 1,
        'type_id' => 2,
        'visibility_id' => 1,
        'metadata' => [
            'url' => 'https://www.google.com',
            'icon' => 'fa-solid fa-towers',
        ],
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all entity_assets')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->get('/api/1.0/campaigns/1/entities/1/entity_assets')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->get('/api/1.0/campaigns/1/entities/1/entity_assets/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_assets/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('includes the asset type when editing a file', function () {
    $this->asUser()
        ->withCampaign()
        ->withCharacters();

    EntityAsset::factory()->create([
        'entity_id' => 1,
        'type_id' => EntityAssetType::file,
    ]);

    $this->get(route('entities.entity_assets.edit', [1, 1, 1]))
        ->assertSuccessful()
        ->assertSee('<input type="hidden" name="type_id" value="1" />', false);
});

it('updates a file without requiring a replacement upload', function () {
    $this->asUser()
        ->withCampaign()
        ->withCharacters();

    $asset = EntityAsset::factory()->create([
        'entity_id' => 1,
        'type_id' => EntityAssetType::file,
    ]);

    $this->patch(route('entities.entity_assets.update', [1, 1, $asset]), [
        'type_id' => EntityAssetType::file->value,
        'name' => 'Renamed file',
    ])->assertRedirect(route('entities.entity_assets.index', [1, 1]));

    expect($asset->refresh()->name)->toBe('Renamed file');
});

it('DELETES an asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_assets/1')
    ->assertStatus(204);

it('DELETES an invalid asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_assets/100')
    ->assertStatus(404);
