<?php

use App\Events\Maps\TilingChanged;
use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Event;

it('broadcasts running/error/finished status derived from the image', function () {
    $running = new TilingChanged(1, 'running');
    expect($running->broadcastAs())->toBe('MapTilingChanged');
    expect($running->broadcastWith())->toBe(['status' => 'running']);
    expect($running->broadcastOn()[0])->toBeInstanceOf(PresenceChannel::class);
});

it('broadcasts once per distinct map whose base image matches, via broadcastForImage', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_FINISHED]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    TilingChanged::broadcastForImage($image);

    Event::assertDispatched(TilingChanged::class, fn ($event) => $event->mapId === $map->id && $event->status === 'finished');
});

it('broadcasts for every map layer referencing the image too', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    TilingChanged::broadcastForImage($image);

    Event::assertDispatched(TilingChanged::class, fn ($event) => $event->mapId === $map->id && $event->status === 'running');
});

it('deduplicates when a map\'s base image and one of its layers are the same image', function () {
    Event::fake([TilingChanged::class]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_ERROR]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();
    MapLayer::factory()->create(['map_id' => $map->id, 'image_uuid' => $image->id]);

    TilingChanged::broadcastForImage($image);

    Event::assertDispatchedTimes(TilingChanged::class, 1);
});
