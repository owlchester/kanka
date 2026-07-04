<?php

use App\Models\Character;
use App\Models\Map;

it('404s for a non-map entity', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    $this->get(route('entities.map', [1, $entity]))->assertStatus(404);
});

it('renders the map page for a map entity', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertStatus(200)
        ->assertSee('map-explorer', false)
        ->assertSee(route('entities.map-api', [$map->entity->campaign, $map->entity]), false);
});

it('redirects to the entity page when the map cannot be explored', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => false]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertRedirect(route('entities.show', [$map->entity->campaign, $map->entity]));
});
