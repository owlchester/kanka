<?php

use App\Events\Maps\Updated;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

it('POSTS an invalid map form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/maps', [])
    ->assertStatus(422);

it('POSTS a new map')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/maps', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('POSTS a real map with the real map zoom limit', function () {
    $this->asUser()->withCampaign();
    $limits = config('limits.maps.zoom.real');

    $this->postJson('/api/1.0/campaigns/1/maps', [
        'name' => fake()->name(),
        'is_real' => true,
        'min_zoom' => $limits['min'],
        'max_zoom' => $limits['max'],
        'initial_zoom' => $limits['max'],
    ])
        ->assertCreated();
});

it('rejects a map zoom value above its configured limit', function () {
    $this->asUser()->withCampaign();

    $this->postJson('/api/1.0/campaigns/1/maps', [
        'name' => fake()->name(),
        'is_real' => true,
        'max_zoom' => config('limits.maps.zoom.real.max') + 1,
    ])->assertUnprocessable();
});

it('saves clustering changes from the entity form', function (bool $enabled) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'has_clustering' => ! $enabled]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
        'has_clustering' => $enabled ? '1' : '0',
    ])->assertRedirect()->assertSessionHasNoErrors();

    expect($map->fresh()->isClustered())->toBe($enabled);
})->with([true, false]);

it('preserves clustering when the entity form omits it', function (bool $enabled) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'has_clustering' => $enabled]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
    ])->assertRedirect()->assertSessionHasNoErrors();

    expect($map->fresh()->isClustered())->toBe($enabled);
})->with([true, false]);

it('saves grid distance and center marker settings from the entity form', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'config' => ['legacy_pins' => true]]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
        'grid' => '50',
        'config' => ['distance_name' => 'Leagues', 'distance_measure' => '0.5'],
        'center_marker_id' => (string) $marker->id,
    ])->assertRedirect()->assertSessionHasNoErrors();

    $map->refresh();
    expect($map->grid)->toBe(50)
        ->and($map->config['distance_name'])->toBe('Leagues')
        ->and((float) $map->config['distance_measure'])->toBe(0.5)
        ->and($map->config['legacy_pins'])->toBeTrue()
        ->and($map->center_marker_id)->toBe($marker->id);
});

it('clears optional settings from the entity form', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'grid' => 50,
        'config' => ['distance_name' => 'Leagues', 'distance_measure' => 0.5],
    ]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $map->update(['center_marker_id' => $marker->id]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
        'grid' => '',
        'config' => ['distance_name' => '', 'distance_measure' => ''],
        'center_marker_id' => '',
    ])->assertRedirect()->assertSessionHasNoErrors();

    $map->refresh();
    expect($map->grid)->toBe(0)
        ->and($map->config)->toBe(['distance_name' => null, 'distance_measure' => null])
        ->and($map->center_marker_id)->toBeNull();
});

it('rejects invalid map settings from the entity form', function (array $settings, string $field) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
        ...$settings,
    ])->assertSessionHasErrors($field);
})->with([
    'clustering' => [['has_clustering' => 'invalid'], 'has_clustering'],
    'negative grid' => [['grid' => -1], 'grid'],
    'fractional grid' => [['grid' => 1.5], 'grid'],
    'long distance name' => [['config' => ['distance_name' => str_repeat('a', 21)]], 'config.distance_name'],
    'small distance measure' => [['config' => ['distance_measure' => 0]], 'config.distance_measure'],
    'large distance measure' => [['config' => ['distance_measure' => 101]], 'config.distance_measure'],
    'invalid config' => [['config' => 'invalid'], 'config'],
    'unknown config key' => [['config' => ['unknown' => true]], 'config'],
    'missing center marker' => [['center_marker_id' => 999999], 'center_marker_id'],
]);

it('rejects a center marker from another map in the entity form', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $otherMap->id]);

    $this->patch(route('entities.update', [1, $map->entity]), [
        'name' => $map->entity->name,
        'center_marker_id' => $marker->id,
    ])->assertSessionHasErrors('center_marker_id');

    expect($map->fresh()->center_marker_id)->toBeNull();
});

it('creates a map with settings through the API', function () {
    $this->asUser()->withCampaign();

    $response = $this->postJson('/api/1.0/campaigns/1/maps', [
        'name' => 'Configured map',
        'has_clustering' => false,
        'grid' => 0,
        'config' => ['distance_name' => 'Miles', 'distance_measure' => 1],
    ])->assertCreated();

    $map = Map::findOrFail($response->json('data.id'));
    expect($map->isClustered())->toBeFalse()
        ->and($map->grid)->toBe(0)
        ->and($map->config)->toBe(['distance_name' => 'Miles', 'distance_measure' => 1]);
});

it('restricts API center markers to the map being updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $otherMap = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $this->putJson('/api/1.0/campaigns/1/maps/' . $map->id, [
        'center_marker_id' => $marker->id,
    ])->assertSuccessful();

    expect($map->fresh()->center_marker_id)->toBe($marker->id);

    $this->putJson('/api/1.0/campaigns/1/maps/' . $otherMap->id, [
        'center_marker_id' => $marker->id,
    ])->assertUnprocessable()->assertJsonValidationErrors('center_marker_id', 'fields');
});

it('preserves omitted config values when updating map settings through the API', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'config' => ['legacy_pins' => true, 'distance_name' => 'Miles', 'distance_measure' => 1],
    ]);

    $this->putJson('/api/1.0/campaigns/1/maps/' . $map->id, [
        'config' => ['distance_name' => 'Leagues'],
    ])->assertSuccessful();

    expect($map->fresh()->config)->toBe([
        'legacy_pins' => true,
        'distance_name' => 'Leagues',
        'distance_measure' => 1,
    ]);
});

it('uses the real map zoom limits when clamping zoom values', function () {
    $this->asUser()->withCampaign();
    $limits = config('limits.maps.zoom.real');
    $map = Map::factory()->create([
        'campaign_id' => 1,
        'is_real' => true,
        'min_zoom' => $limits['min'] - 1,
        'max_zoom' => $limits['max'] + 1,
        'initial_zoom' => $limits['max'] + 1,
    ]);

    expect($map->minZoom())->toBe($limits['min'])
        ->and($map->maxZoom())->toBe((float) $limits['max'])
        ->and($map->initialZoom())->toBe($limits['max']);
});

it('rejects a negative minimum zoom when updating a tiled map through the API', function () {
    $this->asUser()->withCampaign()->withMaps();
    $map = Map::findOrFail(1);
    $image = Image::factory()->create([
        'campaign_id' => 1,
        'tiling_status' => Image::TILING_FINISHED,
    ]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->refresh();

    $this->putJson('/api/1.0/campaigns/1/maps/1', [
        'min_zoom' => -1,
    ])->assertUnprocessable();
});

it('GETS all maps')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->get('/api/1.0/campaigns/1/maps')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->get('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->putJson('/api/1.0/campaigns/1/maps/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid map without a name')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->putJson('/api/1.0/campaigns/1/maps/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->delete('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(204);

it('DELETES an invalid map')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->delete('/api/1.0/campaigns/1/maps/100')
    ->assertStatus(404);

it('can GET a map as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1')
    ->assertStatus(200);

it('calculates bounds from a partial image stream without downloading the full file', function () {
    $this->asUser()->withCampaign();

    $map = Map::factory()->create(['campaign_id' => 1]);

    // Build a real 80×40 PNG in memory so getimagesizefromstring() can parse it
    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $path = 'entities/test-bounds.png';
    Storage::put($path, $pngBytes);

    $entity = $map->entity;
    $entity->image_path = $path;
    $entity->saveQuietly();
    $map->load('entity');

    expect($map->bounds())->toBe('[[0, 0], [40, 80]]');
    expect($map->height)->toBe(40);
    expect($map->width)->toBe(80);
});

it('uses the gallery image dimensions for bounds without caching them on the map row', function () {
    $this->asUser()->withCampaign();

    $map = Map::factory()->create(['campaign_id' => 1]);

    $gd = imagecreatetruecolor(80, 40);
    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $image = Image::factory()->create(['campaign_id' => 1, 'ext' => 'png']);
    Storage::put($image->path, $pngBytes);

    $entity = $map->entity;
    $entity->image_uuid = $image->id;
    $entity->saveQuietly();
    $map->load('entity.image');

    expect($map->bounds())->toBe('[[0, 0], [40, 80]]');
    expect($map->height)->toBe(40);
    expect($map->width)->toBe(80);
    expect($map->fresh()->height)->toBeNull();
    expect($map->fresh()->width)->toBeNull();
});

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private map as a player', function () {
    $this->asUser()
        ->withCampaign();

    Map::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/maps/1');
    expect($response->status())
        ->toBe(403);
});

it('dispatches Maps\Updated when the API updates a map\'s name', function () {
    Event::fake([Updated::class]);
    $this->asUser()->withCampaign()->withMaps();

    $this->putJson('/api/1.0/campaigns/1/maps/1', ['name' => 'Renamed via API'])
        ->assertStatus(200);

    Event::assertDispatched(Updated::class, fn ($event) => $event->map->id === 1);
});

it('is not tiled when its entity has no gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeFalse();
    expect($map->tilingReady())->toBeTrue();
});

it('is not tiled for a legacy image_path-only map (no gallery Image row)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_path = 'maps/legacy.png';
    $map->entity->saveQuietly();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeFalse();
    expect($map->tilingReady())->toBeTrue();
    expect($map->explorable())->toBeTrue();
});

it('proxies tiling state from its entity\'s gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->refresh();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingRunning())->toBeTrue();
    expect($map->tilingReady())->toBeFalse();
    expect($map->explorable())->toBeFalse();
});

it('falls back to explorable plain rendering when tiling permanently errored', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    $map->refresh();

    expect($map->isTiled())->toBeFalse();
    expect($map->tilingError())->toBeTrue();
    expect($map->tilingReady())->toBeTrue();
    expect($map->explorable())->toBeTrue();
});

it('blocks editing a map while its image is being tiled', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->get(route('maps.edit', [1, $map->id]))
        ->assertRedirect(route('entities.show', [$map->entity->campaign, $map->entity]));
});

it('allows editing a map whose image permanently failed tiling (falls back, not blocked)', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    // Not blocked by the tiling-running guard: falls through to the normal
    // crudEdit() flow, which redirects Map (a MiscModel) to the unified entity edit page.
    $this->get(route('maps.edit', [1, $map->id]))
        ->assertRedirect(route('entities.edit', [$map->entity->campaign, $map->entity]));
});

it('centers a tiled map on the middle of its actual image, not (0,0)', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'height' => 3000, 'width' => 4000]);
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    expect($map->centerFocus())->toBe('1500, 2000');
});

it('honors a configured center of 0,0', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'center_x' => 0, 'center_y' => 0]);

    expect($map->centerFocus())->toBe('0, 0');
});
