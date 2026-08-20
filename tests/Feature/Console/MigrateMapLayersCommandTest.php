<?php

use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

beforeEach(function () {
    $this->asUser()->withCampaign();
});

function legacyMapLayer(string $source): MapLayer
{
    $map = Map::factory()->create(['campaign_id' => Campaign::query()->firstOrFail()->id]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);
    $layer->forceFill(['image_path' => $source])->saveQuietly();

    return $layer;
}

function mapLayerDestination(MapLayer $layer, string $source, string $extension): string
{
    $uuid = Uuid::uuid5(
        Uuid::NAMESPACE_URL,
        "kanka:legacy-map-layer:{$layer->map->campaign_id}:{$layer->id}:{$source}",
    )->toString();

    return "w/{$layer->map->campaign_id}/legacy/map_layers/{$uuid}.{$extension}";
}

it('is a dry run unless execute is supplied', function () {
    $source = 'map_layers/dry-run.jpg';
    $layer = legacyMapLayer($source);
    $destination = mapLayerDestination($layer, $source, 'jpg');
    Storage::disk('s3')->put($source, 'image');

    $this->artisan('images:migrate-map-layers')
        ->expectsOutputToContain("{$layer->id}: {$source} -> {$destination}")
        ->expectsTable(['Metric', 'Count'], [
            ['Candidates', 1],
            ['Migrated', 0],
            ['Missing sources', 0],
            ['Unresolved extensions', 0],
            ['Destination conflicts', 0],
            ['Failures', 0],
        ])
        ->expectsOutputToContain('Dry run. Nothing was moved.')
        ->assertSuccessful();

    expect($layer->fresh()->image_path)->toBe($source);
    Storage::disk('s3')->assertExists($source);
    Storage::disk('s3')->assertMissing($destination);
});

it('moves map layer images and updates their paths', function () {
    $source = 'map_layers/overlay.webp';
    $layer = legacyMapLayer($source);
    $destination = mapLayerDestination($layer, $source, 'webp');
    Storage::disk('s3')->put($source, 'image');

    $this->artisan('images:migrate-map-layers', ['--execute' => true])
        ->expectsOutputToContain("{$layer->id}: {$source} -> {$destination}")
        ->assertSuccessful();

    expect($layer->fresh()->image_path)->toBe($destination);
    Storage::disk('s3')->assertMissing($source);
    Storage::disk('s3')->assertExists($destination);
});

it('detects the extension of extensionless images from s3', function () {
    $source = 'map_layers/extensionless';
    $layer = legacyMapLayer($source);
    $destination = mapLayerDestination($layer, $source, 'png');
    Storage::disk('s3')->put($source, "\x89PNG\x0D\x0A\x1A\x0Aimage-content");

    $this->artisan('images:migrate-map-layers', ['--execute' => true])
        ->assertSuccessful();

    expect($layer->fresh()->image_path)->toBe($destination);
    Storage::disk('s3')->assertMissing($source);
    Storage::disk('s3')->assertExists($destination);
});

it('reports missing sources without changing map layer paths', function () {
    $source = 'map_layers/missing.png';
    $layer = legacyMapLayer($source);

    $this->artisan('images:migrate-map-layers', ['--execute' => true])
        ->expectsOutputToContain("Layer {$layer->id}: source does not exist: {$source}")
        ->expectsTable(['Metric', 'Count'], [
            ['Candidates', 1],
            ['Migrated', 0],
            ['Missing sources', 1],
            ['Unresolved extensions', 0],
            ['Destination conflicts', 0],
            ['Failures', 0],
        ])
        ->assertSuccessful();

    expect($layer->fresh()->image_path)->toBe($source);
});

it('does not overwrite an existing destination', function () {
    $source = 'map_layers/conflict.gif';
    $layer = legacyMapLayer($source);
    $destination = mapLayerDestination($layer, $source, 'gif');
    Storage::disk('s3')->put($source, 'source');
    Storage::disk('s3')->put($destination, 'destination');

    $this->artisan('images:migrate-map-layers', ['--execute' => true])
        ->expectsOutputToContain("Layer {$layer->id}: destination already exists: {$destination}")
        ->assertSuccessful();

    expect($layer->fresh()->image_path)->toBe($source)
        ->and(Storage::disk('s3')->get($destination))->toBe('destination');
    Storage::disk('s3')->assertExists($source);
});
