<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Map;

test('a field:map mention renders an inline map preview when requested', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $author->entry = '[map:' . $map->entity->id . '|field:map]';
    $author->save();

    $rendered = $author->parsedEntry(renderMapPreview: true);

    expect($rendered)->toContain('js-map-preview');
    $campaign = Campaign::find(1);
    expect($rendered)->toContain('data-api="' . route('entities.map-api', [$campaign, $map->entity->id]) . '"');
    expect($rendered)->toContain('data-explore-url="' . route('entities.map', [$campaign, $map->entity->id]) . '"');
    expect($rendered)->not->toContain('<iframe');
});

test('a field:map mention renders a plain explore link by default', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $author->entry = '[map:' . $map->entity->id . '|field:map]';
    $author->save();

    $rendered = $author->parsedEntry();

    $campaign = Campaign::find(1);
    expect($rendered)->toContain('<a href="' . route('entities.map', [$campaign, $map->entity->id]) . '" class="text-link">');
    expect($rendered)->toContain(__('maps.actions.explore_named', ['name' => $map->name]));
    expect($rendered)->not->toContain('<iframe');
    expect($rendered)->not->toContain('js-map-preview');
});
