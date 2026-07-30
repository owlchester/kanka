<?php

use App\Models\Map;
use App\Models\MapMarker;

test('a custom icon with an attribute breakout payload is rejected', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'custom_icon' => 'fa-solid fa-skull" onmousehover="alert(1)',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('custom_icon');
    expect(MapMarker::count())->toBe(0);
});

test('a plain fontawesome custom icon class is accepted and stored as-is', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'custom_icon' => 'fa-solid fa-skull',
    ]);

    $response->assertStatus(201);
    expect(MapMarker::latest('id')->first()->custom_icon)->toBe('fa-solid fa-skull');
});

test('a plain rpg-awesome custom icon class is accepted', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'custom_icon' => 'ra ra-sword',
    ]);

    $response->assertStatus(201);
    expect(MapMarker::latest('id')->first()->custom_icon)->toBe('ra ra-sword');
});

test('a custom svg icon is still accepted', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);

    $svg = '<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>';

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
        'custom_icon' => $svg,
    ]);

    $response->assertStatus(201);
    expect(MapMarker::latest('id')->first()->custom_icon)->toContain('<svg');
});

test('an attribute breakout payload written outside request validation is stripped on save', function () {
    $this->asUser()->withCampaign(['boost_count' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);

    // Mirrors how campaign import (MapMapper) writes custom_icon straight onto the model,
    // bypassing StoreMapMarker entirely - the observer must be the one to catch this.
    $marker = MapMarker::factory()->create([
        'map_id' => $map->id,
        'icon' => 1,
        'custom_icon' => 'fa-solid fa-skull" onmousehover="alert(1)',
    ]);

    expect($marker->fresh()->custom_icon)->toBeNull();
});
