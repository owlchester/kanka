<?php

use App\Models\Map;

test('the map explore payload includes mentions/gallery URLs', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id]));

    $response->assertStatus(200);
    $response->assertJsonPath('map.mentions_url', route('search.mention', [1]));
    $response->assertJsonPath('map.gallery_url', route('gallery.tiptap', [1]));
    $response->assertJsonPath('map.gallery_upload_url', route('campaign.gallery.ajax-upload', 1));
});

test('the map explore payload centers and flags the requested focus marker', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = $map->markers()->create([
        'name' => 'Focus marker',
        'latitude' => 12.5,
        'longitude' => 34.5,
        'icon' => 1,
        'shape_id' => 1,
    ]);

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id, 'focus' => $marker->id]));

    $response->assertStatus(200);
    $response->assertJsonPath('map.focus_pin_id', $marker->id);
    $response->assertJsonPath('map.center', [12.5, 34.5]);
});

test('the map explore payload has no focus pin id without a focus param', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id]));

    $response->assertStatus(200);
    $response->assertJsonPath('map.focus_pin_id', null);
});
