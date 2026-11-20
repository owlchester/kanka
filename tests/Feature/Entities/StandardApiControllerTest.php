<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use App\Services\Entity\StandardEntityCreationService;

it('only resolves standard API resources in the requested campaign', function (string $type) {
    $this->asUser()->withCampaign()->withCampaigns();
    $child = app(StandardEntityCreationService::class)->campaign(Campaign::findOrFail(2))
        ->entityType(EntityType::findOrFail(config("entities.ids.$type")))
        ->create(['name' => 'Unchanged']);
    $plural = $child->entity->entityType->pluralCode();
    $foreignUrl = "/api/1.0/campaigns/1/$plural/{$child->id}";

    $this->getJson($foreignUrl)->assertNotFound();
    $this->patchJson($foreignUrl, ['name' => 'Changed'])->assertNotFound();
    $this->deleteJson($foreignUrl)->assertNotFound();

    $this->getJson("/api/1.0/campaigns/2/$plural/{$child->id}")
        ->assertOk()
        ->assertJsonPath('data.name', 'Unchanged');
})->with(['note', 'attribute_template']);

it('preserves omitted character traits on patch but clears them on put', function (string $method, array $expected) {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $url = "/api/1.0/campaigns/1/characters/{$character->id}";

    $this->putJson($url, ['name' => 'Character', 'appearance_name' => ['Scar']])->assertOk();
    $this->json($method, $url, ['name' => 'Renamed'])->assertOk();
    expect($character->characterTraits()->appearance()->pluck('name')->all())->toBe($expected);
})->with([['PATCH', ['Scar']], ['PUT', []]]);
