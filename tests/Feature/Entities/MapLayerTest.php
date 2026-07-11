<?php

use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;

it('POSTS an invalid map layer form')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_layers', [])
    ->assertStatus(422);

it('POSTS a new map layer')
    ->asUser()
    ->withCampaign()
    ->withImages()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_layers', [
        'name' => fake()->name(),
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
        'map_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'map_id',
        ],
    ]);

it('GETS all maps layers')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->putJson('/api/1.0/campaigns/1/maps/1/map_layers/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('DELETES a map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(204);

it('DELETES an invalid map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_layers/100')
    ->assertStatus(404);

it('can GET a map layer as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(200);

it('is explorable only when overlay_shown and has an image', function () {
    $this->asUser()->withCampaign()->withMaps();

    $layer = MapLayer::factory()->create(['map_id' => 1, 'type_id' => 2, 'image_uuid' => null]);
    expect($layer->isExplorable())->toBeFalse();

    $layer->update(['image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeFalse(); // image row doesn't exist yet

    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeTrue();

    $layer->update(['type_id' => null]);
    expect($layer->fresh()->isExplorable())->toBeFalse();
});

it('proxies tiling state from its gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    expect($layer->isTiled())->toBeFalse();
    expect($layer->tilingRunning())->toBeTrue();
    expect($layer->tilingReady())->toBeFalse();
});

it('is not tiled for a legacy image_path-only layer', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);
    $layer->image_path = 'maps/legacy-layer.png';
    $layer->saveQuietly();

    expect($layer->isTiled())->toBeFalse();
    expect($layer->tilingRunning())->toBeFalse();
    expect($layer->tilingReady())->toBeTrue();
});
