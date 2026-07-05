<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapMarker;

it('returns a preview for a marker with an entity, group, and entries', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $group = MapGroup::factory()->create(['map_id' => $map->id, 'name' => 'Towns']);
    // entry lives on the Entity itself (MapMarker::entity()->hasEntry()/parsedEntry() operate on
    // the Entity model, not the Character), and isn't mass-assignable, so set it directly like
    // MapTest.php does for other Entity fields
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $entity->entry = 'Entity entry text';
    $entity->saveQuietly();

    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'group_id' => $group->id,
        'entity_id' => $entity->id,
        'entry' => 'Marker entry text',
        'shape_id' => 1,
    ]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))
        ->assertStatus(200)
        ->assertJsonStructure(['entity_name', 'entity_url', 'entity_image', 'marker_entry', 'entity_entry', 'type', 'group_name', 'can_edit', 'edit_url']);

    expect($response->json('entity_name'))->toBe($entity->name);
    expect($response->json('entity_url'))->toBe($entity->url());
    expect($response->json('type'))->toBe('Marker');
    expect($response->json('group_name'))->toBe('Towns');
    expect($response->json('can_edit'))->toBeTrue();
    expect($response->json('edit_url'))->not->toBeNull();
    expect($response->json('marker_entry'))->toContain('Marker entry text');
    expect($response->json('entity_entry'))->toContain('Entity entry text');
});

it('returns nulls for entity-specific fields when the marker has no linked entity', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('entity_name'))->toBeNull();
    expect($response->json('entity_url'))->toBeNull();
    expect($response->json('entity_image'))->toBeNull();
    expect($response->json('entity_entry'))->toBeNull();
    expect($response->json('group_name'))->toBeNull();
});

it('denies edit permission and hides the edit url for a player', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->asPlayer();

    $response = $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(200);

    expect($response->json('can_edit'))->toBeFalse();
    expect($response->json('edit_url'))->toBeNull();
});

it('404s preview for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->get(route('entities.map-markers.preview', [1, $entity, $marker]))->assertStatus(404);
});

it('404s preview for a marker belonging to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->get(route('entities.map-markers.preview', [1, $map->entity, $marker]))->assertStatus(404);
});

it('deletes a marker and returns 204', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))
        ->assertStatus(204);

    expect(MapMarker::find($marker->id))->toBeNull();
});

it('403s delete for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->asPlayer();

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))
        ->assertStatus(403);

    expect(MapMarker::find($marker->id))->not->toBeNull();
});

it('404s delete for a marker belonging to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->delete(route('entities.map-markers.destroy', [1, $map->entity, $marker]))->assertStatus(404);
});

it('creates a marker and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New pin')->firstOrFail();

    expect($response->json('id'))->toBe($marker->id);
    expect($response->json('name'))->toBe('New pin');
    expect($response->json('colour'))->toBe('#f2c14e');
    expect($response->json('shape'))->toBe('marker');
    expect($response->json('icon'))->toBe(['type' => 'fa', 'value' => 'fa-solid fa-map-pin']);
    expect($response->json('preview_url'))->toBe(route('entities.map-markers.preview', [1, $map->entity->id, $marker->id]));
    expect($marker->map_id)->toBe($map->id);
});

it('403s create for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(403);

    expect(MapMarker::where('name', 'New pin')->exists())->toBeFalse();
});

it('404s create for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->postJson(route('entities.map-markers.store', [1, $entity]), [
        'name' => 'New pin',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(404);
});

it('422s create when both name and entity_id are missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 1,
        'icon' => 1,
    ])->assertStatus(422);
});

it('creates a polygon marker with custom_shape and polygon_style and returns them in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New area',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 60,
        'shape_id' => 5,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke' => '#123456', 'stroke-width' => 3],
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New area')->firstOrFail();

    expect($response->json('shape'))->toBe('poly');
    expect($response->json('custom_shape'))->toBe([
        [10.5, 20.25],
        [11.75, 21.1],
        [12.25, 19.75],
    ]);
    expect($response->json('polygon_style'))->toBe(['stroke' => '#123456', 'stroke-width' => 3]);
    expect($marker->custom_shape)->toBe('10.500,20.250 11.750,21.100 12.250,19.750');
});

it('422s create when polygon_style has an out-of-range stroke-width', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New area',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 5,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke' => '#123456', 'stroke-width' => 999],
    ])->assertStatus(422);
});

it('creates a circle marker with a positive circle_radius and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New circle',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 50,
        'shape_id' => 3,
        'icon' => 1,
        'circle_radius' => 750,
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New circle')->firstOrFail();

    expect($response->json('shape'))->toBe('circle');
    expect($marker->circle_radius)->toBe(750);
});

it('422s create when circle_radius is zero or negative', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New circle',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 3,
        'icon' => 1,
        'circle_radius' => 0,
    ])->assertStatus(422);
});

it('clears a stale circle_radius when the legacy edit form saves a preset size_id', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 3,
        'size_id' => 6,
        'circle_radius' => 750,
    ]);

    // The legacy form always submits circle_radius, even though a preset size (1-5) is chosen,
    // pre-filled from the marker's previous (now stale) custom radius.
    $this->put(route('maps.map_markers.update', [1, $map, $marker]), [
        'name' => $marker->name,
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 3,
        'icon' => 1,
        'size_id' => 2,
        'circle_radius' => 750,
    ])->assertRedirect();

    expect($marker->fresh()->circle_radius)->toBeNull();
});

it('keeps circle_radius when the legacy edit form saves size_id 6 (custom)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'shape_id' => 3,
        'size_id' => 6,
        'circle_radius' => 750,
    ]);

    $this->put(route('maps.map_markers.update', [1, $map, $marker]), [
        'name' => $marker->name,
        'latitude' => 12.5,
        'longitude' => 34.5,
        'shape_id' => 3,
        'icon' => 1,
        'size_id' => 6,
        'circle_radius' => 900,
    ])->assertRedirect();

    expect($marker->fresh()->circle_radius)->toBe(900);
});

it('creates a path marker with custom_shape and returns it in PinResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity]), [
        'name' => 'New path',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'colour' => '#f2c14e',
        'opacity' => 75,
        'shape_id' => 6,
        'icon' => 1,
        'custom_shape' => '10.500,20.250 11.750,21.100 12.250,19.750',
        'polygon_style' => ['stroke-width' => 4],
    ])->assertStatus(201);

    $marker = MapMarker::where('name', 'New path')->firstOrFail();

    expect($response->json('shape'))->toBe('path');
    expect($response->json('custom_shape'))->toBe([
        [10.5, 20.25],
        [11.75, 21.1],
        [12.25, 19.75],
    ]);
    expect($marker->custom_shape)->toBe('10.500,20.250 11.750,21.100 12.250,19.750');
});
