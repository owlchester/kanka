<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

test('PinResource returns parsed entry and an edit-ready entry_for_edition', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    $response = $this->getJson(route('entities.map-api', [1, $map->entity->id]));

    $response->assertStatus(200);
    $pin = collect($response->json('pins'))->firstWhere('id', $marker->id);
    expect($pin['entry'])->toContain('<a'); // parsedEntry() resolves the mention to a real link
    expect($pin)->toHaveKey('entry_for_edition');
});
