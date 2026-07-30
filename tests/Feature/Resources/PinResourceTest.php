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
    // entry_for_edition must stay as the raw [type:id] bracket placeholder (not a resolved
    // <a> anchor) — Tiptap's Mention node only recognizes its own span[data-mention] markup
    // on parse, so a pre-resolved anchor gets claimed by the Link extension instead and can
    // never be converted back into a proper mention node client-side.
    expect($pin['entry_for_edition'])->toBe('[character:' . $target->id . ']');
});
