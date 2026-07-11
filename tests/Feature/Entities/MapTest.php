<?php

use App\Events\Maps\Updated;
use App\Models\Image;
use App\Models\Map;
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
