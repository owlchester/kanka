<?php

use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\User;

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
            'map' => ['id', 'name', 'is_real', 'is_tiled', 'tiling', 'tiling_prompt_eligible', 'has_clustering', 'image', 'width', 'height', 'min_zoom', 'max_zoom', 'initial_zoom', 'center', 'tile_url', 'tiles_url', 'create_url', 'has_distance_unit', 'distance_measure', 'distance_name', 'settings' => ['grid', 'min_zoom', 'max_zoom', 'initial_zoom', 'distance_measure', 'distance_name', 'center_x', 'center_y', 'center_marker_id'], 'settings_url', 'show_url', 'edit_url'],
            'layers' => [['id', 'name', 'type_id', 'image', 'position']],
            'groups' => [['id', 'name', 'parent_id', 'position']],
            'pins' => [['id', 'name', 'group_id', 'latitude', 'longitude', 'shape', 'colour', 'font_colour', 'icon', 'size_id', 'pin_size', 'circle_radius', 'opacity', 'preview_url', 'destroy_url', 'is_draggable', 'move_url']],
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'distance', 'surface', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
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

it('marks a finished tiled map with a tiles url', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);
    $tilesUrl = $response->json('map.tiles_url');

    expect($response->json('map.is_tiled'))->toBeTrue();
    expect($tilesUrl)->toEndWith('/{z}/{y}/{x}.webp');
    expect($tilesUrl)->toContain($image->tilesPath());
    expect($response->json('map.tiling'))->toBeNull();
});

it('reports a running tiling status without a tiles url', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_tiled'))->toBeFalse();
    expect($response->json('map.tiling'))->toBe('running');
    expect($response->json('map.tiles_url'))->toBeNull();
});

it('reports an error tiling status and still omits the tiles url (falls back to plain image)', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.is_tiled'))->toBeFalse();
    expect($response->json('map.tiling'))->toBe('error');
    expect($response->json('map.tiles_url'))->toBeNull();
});

it('flags tiling_prompt_eligible for an oversized untiled gallery image', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_eligible'))->toBeTrue();
});

it('does not flag tiling_prompt_eligible once dismissed', function () {
    config(['maps.tiling_threshold_kb' => 100]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 200]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->tiling_prompt_dismissed_at = now();
    $map->saveQuietly();

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_eligible'))->toBeFalse();
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
        'legacy_pins' => false,
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
        'legacy_pins' => false,
    ]);
});

it('reports a min_zoom or initial_zoom of 0 as 0, not null (round-trip fidelity for fantasy maps)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'min_zoom' => 0, 'initial_zoom' => 0]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.settings.min_zoom'))->toBe(0);
    expect($response->json('map.settings.initial_zoom'))->toBe(0);
});

it('overrides the center with lat/lng query params', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'lat' => 12.5, 'lng' => 34.5]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([12.5, 34.5]);
});

it('overrides the center with a focus marker id query param', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'latitude' => 5.5, 'longitude' => 6.6]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([5.5, 6.6]);
});

it('falls back to the configured center when focus is a marker from a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toEqual([2.0, 1.0]);
});

it('falls back to the configured center when focus does not match any marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => 999999]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toEqual([2.0, 1.0]);
});

it('falls back to the configured center when focus points at a hidden polygon marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 5,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'latitude' => 5.5,
        'longitude' => 6.6,
    ]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toEqual([2.0, 1.0]);
});

it('prefers lat/lng over focus when both are present', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'latitude' => 5.5, 'longitude' => 6.6]);

    $response = $this->get(route('entities.map-api', [1, $map->entity, 'focus' => $marker->id, 'lat' => 12.5, 'lng' => 34.5]))
        ->assertStatus(200);

    expect($response->json('map.center'))->toBe([12.5, 34.5]);
});

it('exposes is_draggable and move_url for a draggable pin', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'is_draggable' => true]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['is_draggable'])->toBeTrue();
    expect($pin['move_url'])->toBe(route('maps.markers.move', [1, $map->id, $marker->id]));
});

it('reports is_draggable false for a marker without the flag', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id, 'is_draggable' => false]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['is_draggable'])->toBeFalse();
});

it('exposes interactive websocket config when reverb is configured and the user can view the map', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.key'))->toBe('test-key');
    expect($response->json('interactive.host'))->toBe('localhost');
    expect($response->json('interactive.port'))->toBe(8080);
    expect($response->json('interactive.scheme'))->toBe('http');
    expect($response->json('interactive.channel'))->toBe('map.' . $map->id);
    expect($response->json('interactive.user.id'))->toBe(auth()->id());
    expect($response->json('interactive.user.name'))->toBe(auth()->user()->name);
});

it('omits interactive config when reverb is not configured', function () {
    config(['broadcasting.connections.reverb.key' => null]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive'))->toBeNull();
});

it('sets show_presence to false for a solo-member campaign', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.show_presence'))->toBeFalse();
});

it('sets show_presence to true for a campaign with more than one member', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $secondUser = User::factory()->create();
    CampaignUser::create(['campaign_id' => 1, 'user_id' => $secondUser->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.show_presence'))->toBeTrue();
});

it('exposes the tiling prompt url for the migration banner', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('map.tiling_prompt_url'))->toBe(route('entities.map-tiling-prompt.update', [1, $map->entity->id]));
});
