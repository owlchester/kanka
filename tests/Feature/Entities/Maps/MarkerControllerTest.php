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
        ->assertJsonStructure(['entity_url', 'entity_image', 'marker_entry', 'entity_entry', 'type', 'group_name', 'can_edit', 'edit_url']);

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
