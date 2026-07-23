<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

it('POSTS an invalid entity_assets form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [])
    ->assertStatus(422);

it('does not POST an entity_asset with an invalid type')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'type_id' => 0,
        'visibility_id' => 1,
    ])
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

it('GETS legacy entity_assets with an invalid type without crashing', function () {
    $this->asUser()->withCampaign()->withCharacters();

    DB::table('entity_assets')->insert([
        'entity_id' => 1,
        'type_id' => 0,
        'name' => 'Legacy asset',
        'metadata' => '{}',
        'visibility_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->get('/api/1.0/campaigns/1/entities/1/entity_assets')
        ->assertStatus(200)
        ->assertJsonFragment([
            'type_id' => null,
            '_file' => false,
            '_link' => false,
            '_alias' => false,
        ]);
});

it('UPDATES a valid asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_assets/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

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
