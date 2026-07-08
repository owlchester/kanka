<?php

use App\Enums\Visibility;
use App\Events\Maps\LayerChanged;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Event;

it('broadcasts on the map presence channel under the MapLayerChanged name', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    $event = new LayerChanged($layer, 'created');

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapLayerChanged');
});

it('broadcasts a LayerResource for created/updated actions', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'name' => 'Cave Overlay']);

    $payload = new LayerChanged($layer, 'updated')->broadcastWith();

    expect($payload['action'])->toBe('updated');
    expect($payload['id'])->toBe($layer->id);
    expect($payload['layer'])->toBeInstanceOf(LayerResource::class);
    expect($payload['layer']->resource->is($layer))->toBeTrue();
});

it('broadcasts a null layer for the deleted action', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $layer = MapLayer::factory()->create(['map_id' => $map->id]);

    $payload = new LayerChanged($layer, 'deleted')->broadcastWith();

    expect($payload['action'])->toBe('deleted');
    expect($payload['id'])->toBe($layer->id);
    expect($payload['layer'])->toBeNull();
});

it('dispatches LayerChanged with action created when a visible, explorable layer is created', function () {
    Event::fake([LayerChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'created');
});

it('does not dispatch LayerChanged when a layer is created but not explorable', function () {
    Event::fake([LayerChanged::class]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    MapLayer::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All, 'type_id' => null]);

    Event::assertNotDispatched(LayerChanged::class);
});

it('dispatches LayerChanged with action deleted when an explorable layer loses its image on update', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->update(['image_uuid' => null]);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'deleted' && $event->layer->id === $layer->id);
});

it('dispatches LayerChanged with action updated when a layer becomes explorable on update', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All, 'type_id' => null]);

    Event::fake([LayerChanged::class]);
    $layer->update(['type_id' => 2, 'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'updated' && $event->layer->is($layer));
});

it('dispatches LayerChanged exactly once when a visible, explorable layer is updated', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->update(['name' => 'Renamed']);

    Event::assertDispatchedTimes(LayerChanged::class, 1);
});

it('dispatches LayerChanged with action deleted when a visible, explorable layer is deleted', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->delete();

    Event::assertDispatched(LayerChanged::class, fn ($event) => $event->action === 'deleted' && $event->layer->id === $layer->id);
});

it('does not dispatch LayerChanged for restricted-visibility layers', function (Visibility $visibility) {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);
    $layer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => $visibility,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    Event::fake([LayerChanged::class]);
    $layer->update(['name' => 'Still restricted']);
    $layer->delete();

    Event::assertNotDispatched(LayerChanged::class);
})->with([
    'admin' => [Visibility::Admin],
    'self' => [Visibility::Self],
    'admin-self' => [Visibility::AdminSelf],
]);
