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
