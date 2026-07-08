<?php

use App\Enums\Visibility;
use App\Events\Maps\ContentsChanged;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;

it('broadcasts on the public presence channel by default', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $event = new ContentsChanged($map);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PresenceChannel::class);
    expect($channels[0]->name)->toBe('presence-map.' . $map->id);
    expect($event->broadcastAs())->toBe('MapContentsChanged');
});

it('broadcasts on the private admin channel when includeRestricted is true', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $event = new ContentsChanged($map, true);

    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0])->toBeInstanceOf(PrivateChannel::class);
    expect($channels[0]->name)->toBe('private-map.' . $map->id . '.admin');
    expect($event->broadcastAs())->toBe('MapContentsChanged');
});

it('includes only All/Member visibility groups and layers by default', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    $visibleGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::All]);
    $memberGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Member]);
    $adminGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);

    $visibleLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);
    $adminLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::Admin,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    $payload = new ContentsChanged($map)->broadcastWith();

    $groupIds = collect($payload['groups'])->map(fn (GroupResource $g) => $g->resource->id)->all();
    $layerIds = collect($payload['layers'])->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($groupIds)->toContain($visibleGroup->id, $memberGroup->id);
    expect($groupIds)->not->toContain($adminGroup->id);
    expect($layerIds)->toContain($visibleLayer->id);
    expect($layerIds)->not->toContain($adminLayer->id);
});

it('includes restricted-visibility groups and layers when includeRestricted is true', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    Image::factory()->create(['campaign_id' => 1, 'id' => '16598f1b-7d93-36d9-bea5-212bfa1e354b']);

    $adminGroup = MapGroup::factory()->create(['map_id' => $map->id, 'visibility_id' => Visibility::Admin]);
    $adminLayer = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::Admin,
        'type_id' => 2,
        'image_uuid' => '16598f1b-7d93-36d9-bea5-212bfa1e354b',
    ]);

    $payload = new ContentsChanged($map, true)->broadcastWith();

    $groupIds = collect($payload['groups'])->map(fn (GroupResource $g) => $g->resource->id)->all();
    $layerIds = collect($payload['layers'])->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($groupIds)->toContain($adminGroup->id);
    expect($layerIds)->toContain($adminLayer->id);
});

it('excludes non-explorable layers on both channels regardless of visibility', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $notExplorable = MapLayer::factory()->create([
        'map_id' => $map->id,
        'visibility_id' => Visibility::All,
        'type_id' => null,
    ]);

    $publicLayerIds = collect(new ContentsChanged($map)->broadcastWith()['layers'])
        ->map(fn (LayerResource $l) => $l->resource->id)->all();
    $adminLayerIds = collect(new ContentsChanged($map, true)->broadcastWith()['layers'])
        ->map(fn (LayerResource $l) => $l->resource->id)->all();

    expect($publicLayerIds)->not->toContain($notExplorable->id);
    expect($adminLayerIds)->not->toContain($notExplorable->id);
});
