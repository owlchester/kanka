<?php

use App\Jobs\TileImageJob;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Support\Facades\Queue;

it('dismisses the prompt without triggering tiling', function () {
    Queue::fake();
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'dismiss'])
        ->assertOk();

    expect($map->fresh()->tiling_prompt_dismissed_at)->not->toBeNull();
    Queue::assertNotPushed(TileImageJob::class);
});

it('migrates by dismissing and force-triggering tiling regardless of the threshold', function () {
    Queue::fake();
    config(['maps.tiling_threshold_kb' => 999999]);
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'migrate'])
        ->assertOk();

    expect($map->fresh()->tiling_prompt_dismissed_at)->not->toBeNull();
    Queue::assertPushed(TileImageJob::class);
});

it('forbids a non-editor from dismissing the prompt', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();

    $this->patch(route('entities.map-tiling-prompt.update', [1, $map->entity]), ['action' => 'dismiss'])
        ->assertForbidden();
});
