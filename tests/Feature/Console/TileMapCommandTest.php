<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

it('force-triggers tiling for a map\'s gallery image regardless of size', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->artisan('maps:tile', ['map' => $map->id])->assertSuccessful();

    Queue::assertPushed(TileImageJob::class, fn ($job) => $job->image->id === $image->id);
});

it('fails gracefully for a map with no gallery image', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->artisan('maps:tile', ['map' => $map->id])->assertFailed();
});

it('fails gracefully for an unknown map id', function () {
    $this->asUser()->withCampaign();

    $this->artisan('maps:tile', ['map' => 999999])->assertFailed();
});
