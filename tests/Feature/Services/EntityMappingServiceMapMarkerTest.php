<?php

use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Map;
use App\Models\MapMarker;

test('mentioning a character in a marker description creates a MapMarker-owned mention with no entity_id rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', MapMarker::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($marker->id);
    expect($mention->entity_id)->toBeNull();
});

test('a marker mentioning its own PK-coincidental id is not treated as a self-mention', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    // A character entity whose id happens to equal the marker's own id — MapMarker has
    // no self-mention guard (unlike Post/TimelineElement/QuestElement), so this must
    // still create a mention rather than being silently skipped.
    $target = Character::find(1)->entity;

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();

    expect(EntityMention::where('target_id', $target->id)->where('mentionable_type', MapMarker::class)->count())->toBe(1);
});

test('MapMarker::mentions() returns only this marker\'s owned mentions', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);
    $otherMarker = MapMarker::factory()->create(['map_id' => $map->id]);

    EntityMention::create(['mentionable_type' => MapMarker::class, 'mentionable_id' => $marker->id, 'target_id' => $target->id]);
    EntityMention::create(['mentionable_type' => MapMarker::class, 'mentionable_id' => $otherMarker->id, 'target_id' => $target->id]);

    expect($marker->mentions()->count())->toBe(1);
    expect($marker->mentions()->first()->mentionable_id)->toBe($marker->id);
});

test('removing a mention from a marker\'s description deletes the corresponding EntityMention row', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1]);
    $marker = MapMarker::factory()->create(['map_id' => $map->id]);

    $marker->entry = '[character:' . $target->id . ']';
    $marker->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(1);

    $marker->entry = 'no more mentions';
    $marker->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(0);
});
