<?php

use App\Events\Maps\Updated;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Support\Facades\Event;

it('updates a map\'s quick settings and returns the updated MapResource', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => ['distance_measure' => 1, 'distance_name' => 'Km']]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
        'min_zoom' => 2,
        'max_zoom' => 8,
        'initial_zoom' => 4,
        'distance_measure' => 0.5,
        'distance_name' => 'Leagues',
        'center_x' => 12.5,
        'center_y' => 34.5,
    ])->assertStatus(200);

    expect($response->json('settings.grid'))->toBe(50);
    expect($response->json('settings.min_zoom'))->toBe(2);
    expect($response->json('settings.max_zoom'))->toBe(8);
    expect($response->json('settings.initial_zoom'))->toBe(4);
    expect($response->json('settings.distance_measure'))->toBe(0.5);
    expect($response->json('settings.distance_name'))->toBe('Leagues');
    expect($response->json('settings.center_x'))->toBe(12.5);
    expect($response->json('settings.center_y'))->toBe(34.5);

    $map->refresh();
    expect($map->grid)->toBe(50);
    expect($map->config)->toBe(['distance_measure' => 0.5, 'distance_name' => 'Leagues']);
});

it('sets a center_marker_id and clears any existing center_x/center_y', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 1, 'center_y' => 2]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_marker_id' => $marker->id,
    ])->assertStatus(200);

    $map->refresh();
    expect($map->center_marker_id)->toBe($marker->id);
    expect($map->center_x)->toBeNull();
    expect($map->center_y)->toBeNull();
});

it('sets center_x/center_y and clears any existing center_marker_id', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $map->update(['center_marker_id' => $marker->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_x' => 5,
        'center_y' => 6,
    ])->assertStatus(200);

    $map->refresh();
    expect($map->center_marker_id)->toBeNull();
    expect((float) $map->center_x)->toBe(5.0);
    expect((float) $map->center_y)->toBe(6.0);
});

it('422s when center_marker_id belongs to a different map', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'center_marker_id' => $marker->id,
    ])->assertStatus(422);
});

it('422s when min_zoom is out of range', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'min_zoom' => -999,
    ])->assertStatus(422);
});

it('422s when distance_measure is out of range', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'distance_measure' => 500,
    ])->assertStatus(422);
});

it('422s when max_zoom exceeds the legacy form\'s bound', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'max_zoom' => 12,
    ])->assertStatus(422);
});

it('leaves an existing center_marker_id untouched on a partial update that never mentions centering', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $map->update(['center_marker_id' => $marker->id]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 60,
    ])->assertStatus(200);

    $map->refresh();
    expect($map->center_marker_id)->toBe($marker->id);
    expect($map->grid)->toBe(60);
});

it('403s for a player without update permission', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
    ])->assertStatus(403);

    expect($map->fresh()->grid)->not->toBe(50);
});

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->patchJson(route('entities.map-settings.update', [1, $entity]), [
        'grid' => 50,
    ])->assertStatus(404);
});

it('persists and returns legacy_pins', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'legacy_pins' => true,
    ])->assertStatus(200);

    expect($response->json('settings.legacy_pins'))->toBeTrue();

    $map->refresh();
    expect($map->config)->toBe(['legacy_pins' => true]);
});

it('defaults legacy_pins to false when never set', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 50,
    ])->assertStatus(200);

    expect($response->json('settings.legacy_pins'))->toBeFalse();
});

it('dispatches Maps\Updated when settings are saved', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patchJson(route('entities.map-settings.update', [1, $map->entity]), [
        'grid' => 77,
    ])->assertStatus(200);

    Event::assertDispatched(Updated::class, fn ($event) => $event->map->id === $map->id);
});
