<?php

use App\Enums\EntityAssetType;
use App\Facades\Permissions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\EntityLocation;
use App\Models\EntityTag;
use App\Models\EntityType;
use App\Models\Event;
use App\Models\Family;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\Post;
use App\Models\Race;
use App\Models\Tag;
use Laravel\Passport\Passport;

it('keeps parent filter options consistent across entity and child queries', function (string $option) {
    $this->asUser()->withCampaign();

    $parent = Ability::factory()->create(['campaign_id' => 1]);
    $otherParent = Ability::factory()->create(['campaign_id' => 1]);
    $matchingChild = Ability::factory()->create(['campaign_id' => 1]);
    $otherChild = Ability::factory()->create(['campaign_id' => 1]);
    $root = Ability::factory()->create(['campaign_id' => 1]);
    $wrongType = Ability::factory()->create(['campaign_id' => 1]);
    $matchingChild->entity->update(['type' => 'Spell', 'parent_id' => $parent->entity->id]);
    $otherChild->entity->update(['type' => 'Spell', 'parent_id' => $otherParent->entity->id]);
    $root->entity->update(['type' => 'Spell']);
    $wrongType->entity->update(['type' => 'Feat']);

    $entityType = EntityType::findOrFail(config('entities.ids.ability'));
    $filters = [
        'type' => 'Spell',
        'parent_id' => (string) $parent->entity->id,
        'parent_id_option' => $option,
    ];
    $expected = match ($option) {
        'exclude' => [$otherChild->id, $root->id],
        'none' => [$root->id],
        default => [$matchingChild->id],
    };

    expect(Ability::query()->filter($filters)->pluck('abilities.id')->all())
        ->toEqualCanonicalizing($expected);
    expect(Entity::query()->where('type_id', $entityType->id)->filter($filters, $entityType)->pluck('entities.entity_id')->all())
        ->toEqualCanonicalizing($expected);
})->with(['matches' => '', 'does not match' => 'exclude', 'no parent' => 'none']);

it('preserves the empty parent search operator on child queries', function () {
    $this->asUser()->withCampaign();

    $parent = Ability::factory()->create(['campaign_id' => 1]);
    $child = Ability::factory()->create(['campaign_id' => 1]);
    $child->entity->update(['parent_id' => $parent->entity->id]);

    expect(Ability::query()->filter(['parent_id' => '!!'])->pluck('abilities.id')->all())
        ->toBe([$parent->id]);
});

it('keeps entity-backed filters consistent across entity and child queries', function () {
    $this->asUser()->withCampaign();

    $matching = Character::factory()->create(['campaign_id' => 1]);
    $empty = Character::factory()->create(['campaign_id' => 1]);
    $matching->entity->forceFill([
        'image_path' => 'legacy/character.png',
        'is_template' => true,
        'entry' => 'Has an entry',
    ])->saveQuietly();

    EntityAsset::factory()->create([
        'entity_id' => $matching->entity->id,
        'type_id' => EntityAssetType::file,
    ]);
    Post::factory()->create(['entity_id' => $matching->entity->id]);
    Attribute::factory()->create([
        'entity_id' => $matching->entity->id,
        'name' => 'strength',
        'value' => '12',
    ]);
    $matching->entity->sheets()->create([
        'source' => 'marketplace',
        'reference' => 'test-sheet-uuid',
    ]);

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $childIds = fn (array $filters): array => Character::query()
        ->filter($filters)
        ->pluck('characters.id')
        ->all();
    $entityIds = fn (array $filters): array => Entity::query()
        ->where('entities.type_id', $entityType->id)
        ->filter($filters, $entityType)
        ->pluck('entities.id')
        ->all();

    foreach (['has_image', 'template', 'has_entry', 'has_entity_files', 'has_posts', 'has_attributes', 'has_character_sheet'] as $filter) {
        expect($childIds([$filter => '1']))
            ->toContain($matching->id)
            ->not->toContain($empty->id);
        expect($entityIds([$filter => '1']))
            ->toContain($matching->entity->id)
            ->not->toContain($empty->entity->id);

        expect($childIds([$filter => '0']))
            ->toContain($empty->id)
            ->not->toContain($matching->id);
        expect($entityIds([$filter => '0']))
            ->toContain($empty->entity->id)
            ->not->toContain($matching->entity->id);
    }
});

it('applies journal date range filters to the journal date column', function () {
    $this->asUser()->withCampaign();

    $before = Journal::factory()->create(['campaign_id' => 1, 'date' => '2020-01-28']);
    $start = Journal::factory()->create(['campaign_id' => 1, 'date' => '2020-01-29']);
    $within = Journal::factory()->create(['campaign_id' => 1, 'date' => '2021-06-01']);
    $end = Journal::factory()->create(['campaign_id' => 1, 'date' => '2022-07-29']);
    $after = Journal::factory()->create(['campaign_id' => 1, 'date' => '2022-07-30']);
    $entityType = EntityType::findOrFail(config('entities.ids.journal'));

    $entityIds = fn (array $filters): array => Entity::query()
        ->where('entities.type_id', $entityType->id)
        ->filter($filters, $entityType)
        ->pluck('entities.entity_id')
        ->all();

    expect($entityIds(['date_start' => '2020-01-29', 'date_end' => '2022-07-29']))
        ->toContain($start->id, $within->id, $end->id)
        ->not->toContain($before->id, $after->id);
    expect($entityIds(['date_start' => '2020-01-29']))
        ->toContain($start->id)
        ->not->toContain($within->id, $before->id);
    expect($entityIds(['date_end' => '2022-07-29']))
        ->toContain($end->id)
        ->not->toContain($within->id, $after->id);
});

it('uses the canonical image predicate in the typed API', function () {
    $this->asUser()->withCampaign();

    $legacy = Character::factory()->create(['campaign_id' => 1]);
    $withoutImage = Character::factory()->create(['campaign_id' => 1]);
    $legacy->entity->forceFill(['image_path' => 'legacy/character.png'])->saveQuietly();

    $withImage = $this->getJson('/api/1.0/campaigns/1/characters?has_image=1')->assertSuccessful();
    $without = $this->getJson('/api/1.0/campaigns/1/characters?has_image=0')->assertSuccessful();

    expect(collect($withImage->json('data'))->pluck('id')->all())
        ->toContain($legacy->id)
        ->not->toContain($withoutImage->id);
    expect(collect($without->json('data'))->pluck('id')->all())
        ->toContain($withoutImage->id)
        ->not->toContain($legacy->id);
});

it('keeps tag options consistent across entity and child queries', function () {
    $this->asUser()->withCampaign();

    $first = Character::factory()->create(['campaign_id' => 1]);
    $second = Character::factory()->create(['campaign_id' => 1]);
    $both = Character::factory()->create(['campaign_id' => 1]);
    $untagged = Character::factory()->create(['campaign_id' => 1]);
    $firstTag = Tag::factory()->create(['campaign_id' => 1]);
    $secondTag = Tag::factory()->create(['campaign_id' => 1]);

    EntityTag::factory()->create(['entity_id' => $first->entity->id, 'tag_id' => $firstTag->id]);
    EntityTag::factory()->create(['entity_id' => $second->entity->id, 'tag_id' => $secondTag->id]);
    EntityTag::factory()->create(['entity_id' => $both->entity->id, 'tag_id' => $firstTag->id]);
    EntityTag::factory()->create(['entity_id' => $both->entity->id, 'tag_id' => $secondTag->id]);

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $childIds = fn (array $filters): array => Character::query()
        ->filter($filters)
        ->pluck('characters.id')
        ->all();
    $entityIds = fn (array $filters): array => Entity::query()
        ->where('entities.type_id', $entityType->id)
        ->filter($filters, $entityType)
        ->pluck('entities.id')
        ->all();

    $filters = ['tags' => [$firstTag->id, $secondTag->id]];
    expect($childIds($filters))->toBe([$both->id]);
    expect($entityIds($filters))->toBe([$both->entity->id]);

    $filters['tags_option'] = 'any';
    expect($childIds($filters))
        ->toContain($first->id, $second->id, $both->id)
        ->not->toContain($untagged->id);
    expect($entityIds($filters))
        ->toContain($first->entity->id, $second->entity->id, $both->entity->id)
        ->not->toContain($untagged->entity->id);

    foreach (['' => [$both->id], 'include' => [$both->id], 'all' => [$both->id]] as $option => $expected) {
        $filters = ['tags' => [$firstTag->id, $secondTag->id], 'tags_option' => $option];
        expect($childIds($filters))->toBe($expected);
        expect($entityIds($filters))->toBe([$both->entity->id]);
    }

    $filters = ['tags' => [$firstTag->id], 'tags_option' => 'exclude'];
    expect($childIds($filters))
        ->toContain($second->id, $untagged->id)
        ->not->toContain($first->id, $both->id);
    expect($entityIds($filters))
        ->toContain($second->entity->id, $untagged->entity->id)
        ->not->toContain($first->entity->id, $both->entity->id);

    $filters = ['tags' => [$firstTag->id, $secondTag->id], 'tags_option' => 'exclude_all'];
    expect($childIds($filters))->toContain($first->id, $second->id, $untagged->id)->not->toContain($both->id);
    expect($entityIds($filters))->toContain($first->entity->id, $second->entity->id, $untagged->entity->id)->not->toContain($both->entity->id);

    $filters = ['tags' => [], 'tags_option' => 'none'];
    expect($childIds($filters))->toBe([$untagged->id]);
    expect($entityIds($filters))->toBe([$untagged->entity->id]);

    $filters = ['tags' => [], 'tags_option' => 'not_empty'];
    expect($childIds($filters))->toContain($first->id, $second->id, $both->id)->not->toContain($untagged->id);
    expect($entityIds($filters))->toContain($first->entity->id, $second->entity->id, $both->entity->id)->not->toContain($untagged->entity->id);

    foreach (['any', 'all', 'exclude', 'exclude_all'] as $option) {
        $filters = ['tags_option' => $option];
        expect($childIds($filters))->toContain($first->id, $second->id, $both->id, $untagged->id);
        expect($entityIds($filters))->toContain($first->entity->id, $second->entity->id, $both->entity->id, $untagged->entity->id);
    }

    foreach (['none', 'not_empty'] as $option) {
        $filters = ['tags_option' => $option];
        if ($option === 'none') {
            expect($childIds($filters))->toBe([$untagged->id]);
            expect($entityIds($filters))->toBe([$untagged->entity->id]);
        } else {
            expect($childIds($filters))->toContain($first->id, $second->id, $both->id)->not->toContain($untagged->id);
            expect($entityIds($filters))->toContain($first->entity->id, $second->entity->id, $both->entity->id)->not->toContain($untagged->entity->id);
        }
    }

    $filters = ['tags' => ['', ' ', null, $firstTag->id, (string) $firstTag->id], 'tags_option' => 'any'];
    expect($childIds($filters))->toContain($first->id, $both->id)->not->toContain($second->id, $untagged->id);
    expect($entityIds($filters))->toContain($first->entity->id, $both->entity->id)->not->toContain($second->entity->id, $untagged->entity->id);
});

it('supports legacy family id filters on entity queries', function () {
    $this->asUser()->withCampaign();

    $family = Family::factory()->create(['campaign_id' => 1]);
    $matching = Character::factory()->create(['campaign_id' => 1]);
    $other = Character::factory()->create(['campaign_id' => 1]);
    $matching->characterFamilies()->create(['family_id' => $family->id]);
    $entityType = EntityType::findOrFail(config('entities.ids.character'));

    $results = Entity::query()
        ->where('entities.type_id', $entityType->id)
        ->filter(['family_id' => (string) $family->id], $entityType)
        ->paginate(10);

    expect($results->total())->toBe(1)
        ->and($results->first()->entity_id)->toBe($matching->id)
        ->and($results->pluck('entity_id')->all())->not->toContain($other->id);
});

it('filters character entities without an explicit entity type without colliding with child tables', function () {
    $this->asUser()->withCampaign();

    $race = Race::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $matching = Character::factory()->create(['campaign_id' => 1]);
    $other = Character::factory()->create(['campaign_id' => 1]);
    $matching->races()->attach($race->id);
    $matching->families()->attach($family->id);
    $matching->organisations()->attach($organisation->id);

    expect(Entity::query()->filter([
        'races' => [$race->id],
        'families' => [$family->id],
        'organisations' => [$organisation->id],
    ])->pluck('entities.entity_id')->all())
        ->toEqualCanonicalizing([$matching->id])
        ->not->toContain($other->id);
});

it('does not match character race links through a wrong entity type or an overlapping child id', function () {
    $this->asUser()->withCampaign();

    $race = Race::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->races()->attach($race->id);
    $wrongType = Family::factory()->create(['campaign_id' => 1])->entity;
    $wrongType->update(['entity_id' => $character->id]);
    $type = EntityType::findOrFail(config('entities.ids.character'));

    $matches = Entity::query()->where('entities.id', $wrongType->id)
        ->filter(['races' => [$race->id]], $type)->pluck('entities.id')->all();

    expect($matches)->toBe([]);
});

it('treats private character race links as absent for non-admin filter operators', function (string $option, bool $matches) {
    $this->asUser()->withCampaign();

    $race = Race::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->races()->attach($race->id, ['is_private' => true]);
    $this->asPlayer();

    $filters = ['races' => [$race->id], 'races_option' => $option];
    $childIds = Character::query()->filter($filters)->pluck('characters.id')->all();
    $type = EntityType::findOrFail(config('entities.ids.character'));
    $entityIds = Entity::query()->where('entities.type_id', $type->id)
        ->filter($filters, $type)->pluck('entities.entity_id')->all();

    expect(in_array($character->id, $childIds, true))->toBe($matches)
        ->and(in_array($character->id, $entityIds, true))->toBe($matches);
})->with([
    'any' => ['', false], 'all' => ['all', false], 'not empty' => ['not_empty', false],
    'exclude' => ['exclude', true], 'exclude all' => ['exclude_all', true], 'none' => ['none', true],
]);

it('treats inaccessible race entities as absent through global ACL in both filter paths', function () {
    $this->asUser()->withCampaign();
    $race = Race::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->races()->attach($race->id);
    $race->entity->update(['is_private' => true]);
    $this->asPlayer();

    $type = EntityType::findOrFail(config('entities.ids.character'));
    foreach ([['', false], ['all', false], ['not_empty', false], ['exclude', true], ['exclude_all', true], ['none', true]] as [$option, $shouldMatch]) {
        $filters = ['races' => [$race->id], 'races_option' => $option];
        $childIds = Character::query()->filter($filters)->pluck('characters.id')->all();
        $entityIds = Entity::query()->where('entities.type_id', $type->id)->filter($filters, $type)->pluck('entities.entity_id')->all();
        expect(in_array($character->id, $childIds, true))->toBe($shouldMatch)
            ->and(in_array($character->id, $entityIds, true))->toBe($shouldMatch);
    }
});

it('treats inaccessible family and organisation entities as absent in both filter paths', function (string $field, string $relation, string $model) {
    $this->asUser()->withCampaign();
    $admin = auth()->user();
    $hidden = $model::factory()->create(['campaign_id' => 1]);
    $visible = $model::factory()->create(['campaign_id' => 1]);
    $hiddenCharacter = Character::factory()->create(['campaign_id' => 1]);
    $visibleCharacter = Character::factory()->create(['campaign_id' => 1]);
    $mixedCharacter = Character::factory()->create(['campaign_id' => 1]);
    $unlinkedCharacter = Character::factory()->create(['campaign_id' => 1]);
    foreach ([[$hiddenCharacter, $hidden], [$visibleCharacter, $visible], [$mixedCharacter, $hidden], [$mixedCharacter, $visible]] as [$character, $target]) {
        $character->{$relation}()->attach($target->id);
    }
    $hidden->entity->update(['is_private' => true]);
    $this->asPlayer();

    $type = EntityType::findOrFail(config('entities.ids.character'));
    $queryIds = fn (array $filters): array => Character::query()->filter($filters)->pluck('characters.id')->all();
    $entityIds = fn (array $filters): array => Entity::query()->where('entities.type_id', $type->id)
        ->filter($filters, $type)->pluck('entities.entity_id')->all();
    foreach (['', 'all', 'exclude', 'exclude_all', 'none', 'not_empty'] as $option) {
        $filters = [$field => [$hidden->id, $visible->id], $field . '_option' => $option];
        $expected = match ($option) {
            'all' => [],
            'exclude' => [$hiddenCharacter->id, $unlinkedCharacter->id],
            'none' => [$hiddenCharacter->id, $unlinkedCharacter->id],
            'exclude_all' => [$hiddenCharacter->id, $visibleCharacter->id, $mixedCharacter->id, $unlinkedCharacter->id],
            default => [$visibleCharacter->id, $mixedCharacter->id],
        };
        expect($queryIds($filters), $field . ':' . $option)->toEqualCanonicalizing($expected)
            ->and($entityIds($filters))->toEqualCanonicalizing($expected);
    }

    foreach (['none', 'not_empty'] as $option) {
        $filters = [$field . '_option' => $option];
        $expected = $option === 'none'
            ? [$hiddenCharacter->id, $unlinkedCharacter->id]
            : [$visibleCharacter->id, $mixedCharacter->id];
        expect($queryIds($filters), $field . ':' . $option . ':option-only')->toEqualCanonicalizing($expected);
        expect($entityIds($filters))->toEqualCanonicalizing($expected);
    }

    Passport::actingAs($admin, ['*']);
    Permissions::reload()->reset();
    $adminFilters = [$field => [$hidden->id]];
    expect($queryIds($adminFilters))->toContain($hiddenCharacter->id);
    expect($entityIds($adminFilters))->toContain($hiddenCharacter->id);
})->with([
    'families' => ['families', 'families', Family::class],
    'organisations' => ['organisations', 'organisations', Organisation::class],
]);

it('hides private family and organisation links from non-admin filters in both paths', function (string $field, string $relation, string $model) {
    $this->asUser()->withCampaign();
    $admin = auth()->user();
    $target = $model::factory()->create(['campaign_id' => 1]);
    $privateCharacter = Character::factory()->create(['campaign_id' => 1]);
    $publicCharacter = Character::factory()->create(['campaign_id' => 1]);
    $privateCharacter->{$relation}()->attach($target->id, ['is_private' => true]);
    $publicCharacter->{$relation}()->attach($target->id, ['is_private' => false]);
    $this->asPlayer();

    $type = EntityType::findOrFail(config('entities.ids.character'));
    $queryIds = fn (array $filters): array => Character::query()->filter($filters)->pluck('characters.id')->all();
    $entityIds = fn (array $filters): array => Entity::query()->where('entities.type_id', $type->id)
        ->filter($filters, $type)->pluck('entities.entity_id')->all();
    foreach (['', 'all', 'exclude', 'exclude_all', 'none', 'not_empty'] as $option) {
        $filters = [$field => [$target->id], $field . '_option' => $option];
        $expected = match ($option) {
            'all' => [$publicCharacter->id],
            'exclude', 'none' => [$privateCharacter->id],
            'exclude_all' => [$privateCharacter->id],
            'not_empty' => [$publicCharacter->id],
            default => [$publicCharacter->id],
        };
        expect($queryIds($filters), $field . ':' . $option)->toEqualCanonicalizing($expected)
            ->and($entityIds($filters))->toEqualCanonicalizing($expected);
    }

    Passport::actingAs($admin, ['*']);
    Permissions::reload()->reset();
    $adminFilters = [$field => [$target->id]];
    expect($queryIds($adminFilters))->toContain($privateCharacter->id)
        ->and($entityIds($adminFilters))->toContain($privateCharacter->id);
})->with([
    'families' => ['families', 'families', Family::class],
    'organisations' => ['organisations', 'organisations', Organisation::class],
]);

it('treats inaccessible participant entities as absent through global ACL in both filter paths', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $event = Event::factory()->create(['campaign_id' => 1]);
    $event->participants()->create(['entity_id' => $character->entity->id]);
    $character->entity->update(['is_private' => true]);
    $this->asPlayer();

    $type = EntityType::findOrFail(config('entities.ids.event'));
    foreach ([['', false], ['all', false], ['not_empty', false], ['exclude', true], ['exclude_all', true], ['none', true]] as [$option, $shouldMatch]) {
        $filters = ['participants' => [$character->entity->id], 'participants_option' => $option];
        $childIds = Event::query()->filter($filters)->pluck('events.id')->all();
        $entityIds = Entity::query()->where('entities.type_id', $type->id)->filter($filters, $type)->pluck('entities.entity_id')->all();
        expect(in_array($event->id, $childIds, true))->toBe($shouldMatch)
            ->and(in_array($event->id, $entityIds, true))->toBe($shouldMatch);
    }
});

it('matches event participants consistently for any and all operators', function (string $option, array $expectedIndexes) {
    $this->asUser()->withCampaign();
    $one = Character::factory()->create(['campaign_id' => 1]);
    $two = Character::factory()->create(['campaign_id' => 1]);
    $events = collect(range(1, 4))->map(fn () => Event::factory()->create(['campaign_id' => 1]));
    $events[0]->participants()->create(['entity_id' => $one->entity->id]);
    $events[1]->participants()->create(['entity_id' => $two->entity->id]);
    $events[2]->participants()->create(['entity_id' => $one->entity->id]);
    $events[2]->participants()->create(['entity_id' => $two->entity->id]);
    $type = EntityType::findOrFail(config('entities.ids.event'));
    $filters = ['participants' => ['', $one->entity->id, $one->entity->id, $two->entity->id], 'participants_option' => $option];
    $child = Event::query()->filter($filters)->pluck('events.id')->all();
    $entities = Entity::query()->where('type_id', $type->id)->filter($filters, $type)->pluck('entities.entity_id')->all();
    $expected = collect($expectedIndexes)->map(fn ($index) => $events[$index]->id)->all();
    expect($child)->toEqualCanonicalizing($expected)->and($entities)->toEqualCanonicalizing($expected);
})->with([
    'any' => ['', [0, 1, 2]],
    'all' => ['all', [2]],
    'not any' => ['exclude', [3]],
    'not all includes partial overlap' => ['exclude_all', [0, 1, 3]],
]);

it('matches character relation filters consistently for all operators', function (string $field, string $relation, string $model, string $option, array $expectedIndexes) {
    $this->asUser()->withCampaign();

    $values = [$model::factory()->create(['campaign_id' => 1]), $model::factory()->create(['campaign_id' => 1])];
    $characters = collect(range(0, 4))->map(fn () => Character::factory()->create(['campaign_id' => 1]));
    $unrelated = $model::factory()->create(['campaign_id' => 1]);
    foreach ([0 => [$values[0]], 1 => [$values[1]], 2 => $values, 3 => [$unrelated]] as $index => $related) {
        foreach ($related as $value) {
            if ($field === 'locations') {
                EntityLocation::create(['entity_id' => $characters[$index]->entity->id, 'location_id' => $value->id]);
            } else {
                $characters[$index]->{$relation}()->attach($value->id);
            }
        }
    }

    $type = EntityType::findOrFail(config('entities.ids.character'));
    $filters = [$field . '_option' => $option];
    if (in_array($option, ['', 'all', 'exclude', 'exclude_all'], true)) {
        $filters[$field] = ['', $values[0]->id, $values[0]->id, $values[1]->id];
    }
    $expected = collect($expectedIndexes)->map(fn ($index) => $characters[$index]);
    $childIds = Character::query()->filter($filters)->pluck('characters.id')->all();
    $entityIds = Entity::query()->where('entities.type_id', $type->id)->filter($filters, $type)->pluck('entities.id')->all();

    expect($childIds)->toEqualCanonicalizing($expected->pluck('id')->all())
        ->and($entityIds)->toEqualCanonicalizing($expected->map(fn ($character) => $character->entity->id)->all());
})->with([
    'locations' => ['locations', 'locations', Location::class],
    'races' => ['races', 'races', Race::class],
    'organisations' => ['organisations', 'organisations', Organisation::class],
    'families' => ['families', 'families', Family::class],
])->with([
    'any' => ['', [0, 1, 2]], 'all' => ['all', [2]], 'exclude' => ['exclude', [3, 4]],
    'exclude all' => ['exclude_all', [0, 1, 3, 4]], 'none' => ['none', [4]], 'not empty' => ['not_empty', [0, 1, 2, 3]],
]);

it('supports Empty participant matching without selected values', function () {
    $this->asUser()->withCampaign();
    $empty = Event::factory()->create(['campaign_id' => 1]);
    $filled = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $filled->participants()->create(['entity_id' => $character->entity->id]);
    $type = EntityType::findOrFail(config('entities.ids.event'));
    expect(Event::query()->filter(['participants_option' => 'none'])->pluck('events.id')->all())->toBe([$empty->id]);
    expect(Entity::query()->where('type_id', $type->id)->filter(['participants' => [], 'participants_option' => 'none'], $type)->pluck('entities.entity_id')->all())->toBe([$empty->id]);
});

it('matches event participants that are not empty', function () {
    $this->asUser()->withCampaign();
    $empty = Event::factory()->create(['campaign_id' => 1]);
    $filled = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $filled->participants()->create(['entity_id' => $character->entity->id]);
    $type = EntityType::findOrFail(config('entities.ids.event'));
    expect(Event::query()->filter(['participants_option' => 'not_empty'])->pluck('events.id')->all())->toBe([$filled->id]);
    expect(Entity::query()->where('type_id', $type->id)->filter(['participants_option' => 'not_empty'], $type)->pluck('entities.entity_id')->all())->toBe([$filled->id]);
});

it('ignores empty selections for participant matching operators', function (string $option) {
    $this->asUser()->withCampaign();
    $events = collect(range(1, 3))->map(fn () => Event::factory()->create(['campaign_id' => 1]));
    $character = Character::factory()->create(['campaign_id' => 1]);
    $events[0]->participants()->create(['entity_id' => $character->entity->id]);
    $type = EntityType::findOrFail(config('entities.ids.event'));
    foreach ([['participants_option' => $option], ['participants' => [], 'participants_option' => $option]] as $filters) {
        expect(Event::query()->filter($filters)->pluck('events.id')->all())->toEqualCanonicalizing($events->pluck('id')->all());
        expect(Entity::query()->where('type_id', $type->id)->filter($filters, $type)->pluck('entities.entity_id')->all())->toEqualCanonicalizing($events->pluck('id')->all());
    }
})->with(['any' => '', 'all' => 'all', 'exclude' => 'exclude', 'exclude_all' => 'exclude_all']);
