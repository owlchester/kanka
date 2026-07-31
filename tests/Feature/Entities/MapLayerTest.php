<?php

use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Storage;

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

it('is explorable only when it has an image', function () {
    $this->asUser()->withCampaign()->withMaps();

    $layer = MapLayer::factory()->create(['map_id' => 1, 'type_id' => 2, 'image_uuid' => null]);
    expect($layer->isExplorable())->toBeFalse();

    $layer->update(['image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeFalse(); // image row doesn't exist yet

    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    expect($layer->fresh()->isExplorable())->toBeTrue();

    $layer->update(['type_id' => 1]);
    expect($layer->fresh()->isExplorable())->toBeTrue();

    $layer->update(['type_id' => null]);
    expect($layer->fresh()->isExplorable())->toBeTrue();
});

it('uses the gallery image dimensions for a layer without caching them on the layer row', function () {
    $this->asUser()->withCampaign()->withMaps();

    $gd = imagecreatetruecolor(60, 30);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => $image->id]);

    expect($layer->bounds())->toBe('[[0, 0], [30, 60]]');
    expect($layer->fresh()->width)->toBeNull();
    expect($layer->fresh()->height)->toBeNull();
});

it('falls back to the parent map dimensions when the gallery image has zeroed cached dimensions', function () {
    $this->asUser()->withCampaign()->withMaps();

    $map = Map::find(1);
    $map->update(['height' => 500, 'width' => 250]);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'svg']);
    // An svg with only a viewBox (no width/height attributes) legitimately parses to 0/0,
    // and ensureDimensions() permanently caches that - simulate it directly here.
    $image->metadata = ['width' => 0, 'height' => 0];
    $image->saveQuietly();

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => $image->id]);

    // Without the fix this would be [[0, 0], [0, 0]], collapsing the leaflet overlay to a point.
    expect($layer->bounds())->toBe('[[0, 0], [500, 250]]');
    expect($layer->dimensions())->toBe(['width' => 250, 'height' => 500]);
});

it('reflects the parent map\'s real resolved dimensions in the fallback, not a hardcoded 1000', function () {
    $this->asUser()->withCampaign()->withMaps();

    $map = Map::find(1);

    $gd = imagecreatetruecolor(300, 150);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $entity = $map->entity;
    $entity->image_uuid = $image->id;
    $entity->saveQuietly();

    // No image and no image_path on the layer itself, so it must fall through to the
    // map's own dimensions - which are never persisted for a gallery-image map and must
    // be resolved via Map::prepareBounds() rather than read as null.
    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => null]);

    expect($layer->dimensions())->toBe(['width' => 300, 'height' => 150]);
});

it('calculates and caches dimensions for a legacy image_path layer', function () {
    $this->asUser()->withCampaign()->withMaps();

    $gd = imagecreatetruecolor(100, 50);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $path = 'maps/test-layer-bounds.png';
    Storage::put($path, $pngBytes);

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => null]);
    $layer->image_path = $path;
    $layer->saveQuietly();

    expect($layer->bounds())->toBe('[[0, 0], [50, 100]]');
    expect($layer->fresh()->width)->toBe(100);
    expect($layer->fresh()->height)->toBe(50);
});

it('exposes the gallery image real dimensions, not the null layer columns, in the API json', function () {
    $this->asUser()->withCampaign()->withMaps();

    $gd = imagecreatetruecolor(60, 30);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $layer = MapLayer::factory()->create(['map_id' => 1, 'image_uuid' => $image->id]);

    $this->get('/api/1.0/campaigns/1/maps/1/map_layers/' . $layer->id)
        ->assertStatus(200)
        ->assertJsonFragment(['width' => 60, 'height' => 30]);

    expect($layer->fresh()->width)->toBeNull();
    expect($layer->fresh()->height)->toBeNull();
});
