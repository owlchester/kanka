<?php

use App\Models\Character;
use App\Models\Map;
use App\Models\MapMarker;

test('a marker entry with real HTML and a mention anchor is not double-escaped or paragraph-wrapped', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);

    $html = '<p>Some <strong>bold</strong> text with a mention: <a class="mention" data-name="Character 1" data-mention="[character:' . $target->id . ']"><span>Character 1</span></a></p>';

    $response = $this->postJson(route('entities.map-markers.store', [1, $map->entity->id]), [
        'name' => 'Test Marker',
        'entry' => $html,
        'longitude' => 1,
        'latitude' => 1,
        'shape_id' => 1,
        'icon' => 1,
    ]);

    $response->assertStatus(201);
    $marker = MapMarker::latest('id')->first();
    // The mention anchor is purified into bracket-syntax text by SaveService (unchanged,
    // pre-existing behavior via HasEntry) - what this test guards is that the surrounding
    // HTML was NOT additionally escaped/wrapped by wrapEntryParagraphs(), which would have
    // turned the real <strong> tag into literal "&lt;strong&gt;" text.
    expect($marker->entry)->not->toContain('&lt;strong&gt;');
    expect($marker->entry)->toContain('<strong>bold</strong>');
    expect($marker->entry)->toContain('[character:' . $target->id . ']');
});
