<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->get(route('entities.map-api', [1, $entity]))
        ->assertStatus(404);
});

it('returns the full explore payload for a simple map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'has_clustering' => true]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);

    // image_path isn't mass-assignable (not in MapLayer::$fillable), set it directly like MapTest.php does for entities
    $hiddenLayer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Hidden overlay', 'type_id' => 1]);
    $hiddenLayer->image_path = 'maps/hidden.png';
    $hiddenLayer->saveQuietly();

    $shownLayer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Winter', 'type_id' => 2]);
    $shownLayer->image_path = 'maps/winter.png';
    $shownLayer->saveQuietly();

    MapMarker::factory()->create(['map_id' => $map->id, 'group_id' => $group->id, 'name' => 'Waterdeep']);
    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Uncategorised pin']);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity']],
        ]);

    $response->assertJsonFragment(['name' => $map->name, 'is_real' => false, 'has_clustering' => true]);
    $response->assertJsonFragment(['name' => 'Waterdeep', 'group_id' => $group->id]);
    // The hidden (type_id=1) overlay layer must not be included, only the shown-by-default one
    expect($response->json('layers'))->toHaveCount(1);
    expect($response->json('layers.0.name'))->toBe('Winter');
});

it('marks a real map with a tile url and no image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_real'))->toBeTrue();
    expect($response->json('map.image'))->toBeNull();
    expect($response->json('map.tile_url'))->toBe('https://tile.openstreetmap.org/{z}/{x}/{y}.png');
});

it('marks a finished chunked map with a chunks url', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    // chunking_status isn't mass-assignable (not in Map::$fillable), set it directly like MapTest.php does for image_path
    $map->chunking_status = Map::CHUNKING_FINISHED;
    $map->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);
    $chunksUrl = $response->json('map.chunks_url');

    expect($response->json('map.is_chunked'))->toBeTrue();
    expect($chunksUrl)->toStartWith(route('maps.chunks', [1, $map->id]));
    expect($chunksUrl)->toEndWith('?z={z}&x={x}&y={y}');
});

it('excludes pins whose linked entity has no child (mirrors MapMarker::visible())', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $character->delete(); // leaves an orphaned Entity row - $entity->isMissingChild() becomes true

    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Orphaned entity pin', 'entity_id' => $entity->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('pins'))->toHaveCount(0);
});
