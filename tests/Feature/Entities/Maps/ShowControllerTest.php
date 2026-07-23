<?php

use App\Models\Character;
use App\Models\Image;
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

it('forwards focus/lat/lng query params onto the rendered api url', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1, 'is_real' => true]);

    $this->get(route('entities.map', [1, $map->entity]) . '?lat=12.5&lng=34.5')
        ->assertStatus(200)
        ->assertSee(route('entities.map-api', [$map->entity->campaign, $map->entity, 'lat' => '12.5', 'lng' => '34.5']));
});

it('does not redirect away from the map page while tiling is running (shows inline placeholder instead)', function () {
    $this->asUser()->withCampaign();
    $image = Image::factory()->create(['campaign_id' => 1, 'tiling_status' => Image::TILING_RUNNING]);
    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->image_uuid = $image->id;
    $map->entity->saveQuietly();

    $this->get(route('entities.map', [1, $map->entity]))->assertOk();
});

it('still redirects when the map has no image at all', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $this->get(route('entities.map', [1, $map->entity]))
        ->assertRedirect(route('entities.show', [$map->entity->campaign, $map->entity->id]));
});
