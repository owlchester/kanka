<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Race;
use App\Services\Entity\Connections\MapService;

it('maps every character family and race without expanding race members', function (string $option) {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $relative = Character::factory()->create(['campaign_id' => 1]);
    $unrelated = Character::factory()->create(['campaign_id' => 1]);
    $families = Family::factory()->count(2)->create(['campaign_id' => 1]);
    $races = Race::factory()->count(2)->create(['campaign_id' => 1]);
    $character->families()->attach($families->modelKeys());
    $character->races()->attach($races->modelKeys());
    $relative->families()->attach($families->first()->id);
    $unrelated->races()->attach($races->first()->id);

    $map = app(MapService::class)->user(auth()->user())->campaign(Campaign::first())->entity($character->entity)->option($option)->map();
    $relations = collect($map['relations']);

    expect(array_keys($map['entities']))
        ->toContain($character->entity->id, $relative->entity->id, ...$families->pluck('entity.id')->all(), ...$races->pluck('entity.id')->all())
        ->not->toContain($unrelated->entity->id);
    expect($relations->where('type', 'family-member')->where('target', $character->entity->id)->pluck('source')->all())
        ->toEqualCanonicalizing($families->pluck('entity.id')->all());
    expect($relations->where('type', 'character-race')->where('source', $character->entity->id)->pluck('target')->all())
        ->toEqualCanonicalizing($races->pluck('entity.id')->all());
})->with(['related', 'mentions']);

it('respects private family and race memberships', function (?bool $admin) {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $publicFamily = Family::factory()->create(['campaign_id' => 1]);
    $privateFamily = Family::factory()->create(['campaign_id' => 1]);
    $publicRace = Race::factory()->create(['campaign_id' => 1]);
    $privateRace = Race::factory()->create(['campaign_id' => 1]);
    $character->families()->attach($publicFamily->id, ['is_private' => false]);
    $character->families()->attach($privateFamily->id, ['is_private' => true]);
    $character->races()->attach($publicRace->id, ['is_private' => false]);
    $character->races()->attach($privateRace->id, ['is_private' => true]);

    if ($admin === false) {
        $this->asPlayer();
    }

    $service = app(MapService::class)->campaign(Campaign::first())->entity($character->entity)->option('related');
    if ($admin !== null) {
        $service->user(auth()->user());
    }
    $map = $service->map();

    expect(array_keys($map['entities']))->toContain($publicFamily->entity->id, $publicRace->entity->id);
    expect(isset($map['entities'][$privateFamily->entity->id]))->toBe($admin === true);
    expect(isset($map['entities'][$privateRace->entity->id]))->toBe($admin === true);
})->with(['admin' => true, 'player' => false, 'no injected user' => [null]]);

it('passes the authenticated user to the connection map service', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);
    $race = Race::factory()->create(['campaign_id' => 1]);
    $character->families()->attach($family->id, ['is_private' => true]);
    $character->races()->attach($race->id, ['is_private' => true]);

    $this->getJson(route('entities.relations_map', [1, $character->entity, 'option' => 'related']))
        ->assertSuccessful()
        ->assertJsonPath('entities.' . $family->entity->id . '.id', $family->entity->id)
        ->assertJsonPath('entities.' . $race->entity->id . '.id', $race->entity->id);
});

it('omits inaccessible family race and authored journal entities', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);
    $race = Race::factory()->create(['campaign_id' => 1]);
    $journal = Journal::factory()->create(['campaign_id' => 1, 'author_id' => $character->entity->id]);
    $character->families()->attach($family->id);
    $character->races()->attach($race->id);
    foreach ([$family, $race, $journal] as $model) {
        $model->entity->update(['is_private' => true]);
    }

    $this->asPlayer();

    $map = app(MapService::class)->user(auth()->user())->campaign(Campaign::first())->entity($character->entity)->option('related')->map();

    expect(array_keys($map['entities']))->toBe([$character->entity->id]);
    expect($map['relations'])->toBeEmpty();
});

it('maps authored journals exactly once for every entity type', function (string $model, string $option) {
    $this->asUser()->withCampaign();

    if ($model === 'custom') {
        $entityType = new EntityType(['code' => 'gadget', 'is_special' => true, 'is_enabled' => true]);
        $entityType->campaign_id = 1;
        $entityType->singular = 'Gadget';
        $entityType->plural = 'Gadgets';
        $entityType->icon = 'fa-solid fa-gear';
        $entityType->save();

        $entity = new Entity(['campaign_id' => 1, 'entity_id' => 0, 'name' => 'Widget']);
        $entity->type_id = $entityType->id;
        $entity->save();
    } else {
        $entity = $model::factory()->create(['campaign_id' => 1])->entity;
    }

    $journal = Journal::factory()->create(['campaign_id' => 1, 'author_id' => $entity->id]);
    $otherJournal = Journal::factory()->create(['campaign_id' => 1]);
    $map = app(MapService::class)->user(auth()->user())->campaign(Campaign::first())->entity($entity)->option($option)->map();
    $relations = collect($map['relations'])->where('type', 'journal-author')->values();

    expect(array_keys($map['entities']))->toContain($journal->entity->id)->not->toContain($otherJournal->entity->id);
    expect($relations)->toHaveCount(1);
    expect($relations->first())->toMatchArray(['source' => $entity->id, 'target' => $journal->entity->id]);
})->with([Character::class, Family::class, Location::class, Organisation::class, Map::class, Race::class, Note::class, 'custom'])->with(['related', 'mentions']);

it('excludes related memberships and authored journals from relation-only modes', function (?string $option) {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);
    $race = Race::factory()->create(['campaign_id' => 1]);
    Journal::factory()->create(['campaign_id' => 1, 'author_id' => $character->entity->id]);
    $character->families()->attach($family->id);
    $character->races()->attach($race->id);

    $map = app(MapService::class)->user(auth()->user())->campaign(Campaign::first())->entity($character->entity)->option($option)->map();

    expect(array_keys($map['entities']))->toBe([$character->entity->id]);
    expect($map['relations'])->toBeEmpty();
})->with([null, 'only_relations']);

it('maps characters without families or races', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $map = app(MapService::class)->user(auth()->user())->campaign(Campaign::first())->entity($character->entity)->option('related')->map();

    expect(array_keys($map['entities']))->toBe([$character->entity->id]);
    expect($map['relations'])->toBeEmpty();
});
