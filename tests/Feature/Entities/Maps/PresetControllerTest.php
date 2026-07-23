<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\Map;
use App\Models\Preset;
use App\Models\PresetType;

it('creates a marker preset and returns it in PresetResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Town',
        'shape' => 'marker',
        'colour' => '#f2c14e',
        'icon' => 2,
        'opacity' => 80,
        'is_draggable' => true,
        'css' => 'my-template',
    ])->assertStatus(201);

    $preset = Preset::where('name', 'Town')->firstOrFail();

    expect($response->json('id'))->toBe($preset->id);
    expect($response->json('name'))->toBe('Town');
    expect($response->json('config'))->toBe([
        'shape_id' => 1,
        'colour' => '#f2c14e',
        'icon' => 2,
        'opacity' => 80,
        'is_draggable' => true,
        'css' => 'my-template',
    ]);
});

it('maps a non-pin shape string to its MapMarkerShape value in config', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Lake',
        'shape' => 'circle',
        'colour' => '#3b82f6',
    ])->assertStatus(201);

    expect($response->json('config.shape_id'))->toBe(3);
});

it('defaults shape_id to marker when shape is omitted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Untitled',
    ])->assertStatus(201);

    expect($response->json('config.shape_id'))->toBe(1);
});

it('403s preset creation for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Town',
    ])->assertStatus(403);

    expect(Preset::where('name', 'Town')->exists())->toBeFalse();
});

it('404s preset creation for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->postJson(route('entities.map-presets.store', [1, $entity]), [
        'name' => 'Town',
    ])->assertStatus(404);
});

it('422s preset creation when name is missing', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'colour' => '#f2c14e',
    ])->assertStatus(422);
});

it('makes a newly created preset immediately available from the map setup API', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Town',
        'colour' => '#f2c14e',
    ])->assertStatus(201);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect(collect($response->json('presets'))->pluck('name'))->toContain('Town');
});

it('includes working update_url and destroy_url on a created preset', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-presets.store', [1, $map->entity]), [
        'name' => 'Town',
    ])->assertStatus(201);

    $preset = Preset::where('name', 'Town')->firstOrFail();

    expect($response->json('update_url'))->toBe(route('entities.map-presets.update', [1, $map->entity->id, $preset->id]));
    expect($response->json('destroy_url'))->toBe(route('entities.map-presets.destroy', [1, $map->entity->id, $preset->id]));
});

it('updates a preset and returns it in PresetResource shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $preset = Preset::create([
        'name' => 'Town',
        'type_id' => PresetType::MARKER,
        'campaign_id' => 1,
        'visibility_id' => Visibility::All,
        'config' => ['shape_id' => 1, 'colour' => '#f2c14e'],
    ]);

    $response = $this->patchJson(route('entities.map-presets.update', [1, $map->entity, $preset]), [
        'name' => 'Village',
        'shape' => 'circle',
        'colour' => '#3b82f6',
        'opacity' => 60,
    ])->assertStatus(200);

    expect($response->json('name'))->toBe('Village');
    expect($response->json('config'))->toBe([
        'shape_id' => 3,
        'colour' => '#3b82f6',
        'opacity' => 60,
        'is_draggable' => false,
    ]);
    expect($preset->fresh()->name)->toBe('Village');
});

it('403s preset update for a player without admin permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $preset = Preset::create([
        'name' => 'Town',
        'type_id' => PresetType::MARKER,
        'campaign_id' => 1,
        'visibility_id' => Visibility::All,
        'config' => [],
    ]);

    $this->asPlayer();

    $this->patchJson(route('entities.map-presets.update', [1, $map->entity, $preset]), [
        'name' => 'Village',
    ])->assertStatus(403);

    expect($preset->fresh()->name)->toBe('Town');
});

it('deletes a preset and returns 204', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $preset = Preset::create([
        'name' => 'Town',
        'type_id' => PresetType::MARKER,
        'campaign_id' => 1,
        'visibility_id' => Visibility::All,
        'config' => [],
    ]);

    $this->delete(route('entities.map-presets.destroy', [1, $map->entity, $preset]))
        ->assertStatus(204);

    expect(Preset::find($preset->id))->toBeNull();
});

it('403s preset deletion for a player without admin permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $preset = Preset::create([
        'name' => 'Town',
        'type_id' => PresetType::MARKER,
        'campaign_id' => 1,
        'visibility_id' => Visibility::All,
        'config' => [],
    ]);

    $this->asPlayer();

    $this->delete(route('entities.map-presets.destroy', [1, $map->entity, $preset]))
        ->assertStatus(403);

    expect(Preset::find($preset->id))->not->toBeNull();
});
