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

    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'group_id' => $group->id, 'name' => 'Waterdeep']);
    MapMarker::factory()->create(['map_id' => $map->id, 'name' => 'Uncategorised pin']);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'map' => ['id', 'name', 'is_real', 'is_chunked', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'chunks_url', 'create_url', 'has_distance_unit', 'distance_measure', 'distance_name', 'settings' => ['grid', 'min_zoom', 'max_zoom', 'initial_zoom', 'distance_measure', 'distance_name', 'center_x', 'center_y', 'center_marker_id'], 'settings_url', 'show_url', 'edit_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url']],
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']]],
        ]);

    $response->assertJsonFragment(['name' => $map->name, 'is_real' => false, 'has_clustering' => true]);
    $response->assertJsonFragment(['name' => 'Waterdeep', 'group_id' => $group->id]);
    expect($response->json('map.create_url'))->toBe(route('entities.map-markers.store', [1, $map->entity->id]));
    // The hidden (type_id=1) overlay layer must not be included, only the shown-by-default one
    expect($response->json('layers'))->toHaveCount(1);
    expect($response->json('layers.0.name'))->toBe('Winter');

    $pins = collect($response->json('pins'));
    $waterdeep = $pins->firstWhere('name', 'Waterdeep');
    expect($waterdeep['preview_url'])->toBe(route('entities.map-markers.preview', [1, $map->entity->id, $marker->id]));
    expect($waterdeep['destroy_url'])->toBe(route('entities.map-markers.destroy', [1, $map->entity->id, $marker->id]));
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

// This exercises MapMarker::visible()'s entity/isMissingChild() branch, not its group_id/group
// branch (private group -> pin excluded), because App\Models\Scopes\VisibilityIDScope::apply()
// returns early whenever app()->runningInConsole() is true - which is true for this entire test
// process, so MapGroup's own visibility scope can never actually filter anything under Pest.
// That's a pre-existing, unrelated bug affecting every model using HasVisibility; production
// behavior is unaffected (real requests aren't "running in console"), but it means the
// private-group exclusion path in ExploreApiService/MapMarker::visible() has no automated
// coverage today. See docs/superpowers/plans/2026-07-03-entity-map-vue-explorer.md, Task 2.
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

it('exposes the configured distance unit for a map with one set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'config' => ['distance_measure' => 0.5, 'distance_name' => 'Leagues'],
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200);

    expect($response->json('map.has_distance_unit'))->toBeTrue();
    expect($response->json('map.distance_measure'))->toBe(0.5);
    expect($response->json('map.distance_name'))->toBe('Leagues');
});

it('defaults the distance unit name to Km and omits distance_measure for a map with none set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => []]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))
        ->assertStatus(200);

    expect($response->json('map.has_distance_unit'))->toBeFalse();
    expect($response->json('map.distance_measure'))->toBeNull();
    expect($response->json('map.distance_name'))->toBe('Km');
});

it('exposes a map\'s raw settings values and edit urls for the quick-settings panel', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'center_x' => 12.5,
        'center_y' => 34.5,
        'config' => ['distance_measure' => 0.5, 'distance_name' => 'Leagues'],
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings'))->toBe([
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'distance_measure' => 0.5,
        'distance_name' => 'Leagues',
        'center_x' => 12.5,
        'center_y' => 34.5,
        'center_marker_id' => null,
    ]);
    expect($response->json('map.settings_url'))->toBe(route('entities.map-settings.update', [1, $map->entity->id]));
    expect($response->json('map.show_url'))->toBe(route('entities.show', [1, $map->entity->id]));
    expect($response->json('map.edit_url'))->toBe(route('entities.edit', [1, $map->entity->id]));
});

it('returns null settings values for a map with none configured', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => []]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings'))->toBe([
        'grid' => null,
        'min_zoom' => null,
        'max_zoom' => null,
        'initial_zoom' => null,
        'distance_measure' => null,
        'distance_name' => null,
        'center_x' => null,
        'center_y' => null,
        'center_marker_id' => null,
    ]);
});

it('reports a min_zoom or initial_zoom of 0 as 0, not null (round-trip fidelity for fantasy maps)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'min_zoom' => 0, 'initial_zoom' => 0]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings.min_zoom'))->toBe(0);
    expect($response->json('map.settings.initial_zoom'))->toBe(0);
});
