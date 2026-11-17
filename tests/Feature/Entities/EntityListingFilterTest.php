<?php

use App\Models\Ability;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\Image;
use Illuminate\Support\Arr;

it('filters abilities by type and parent without treating the filter as navigation', function (string $option, bool $nested) {
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
        'parent_id' => $parent->entity->id,
        'parent_id_option' => $option,
        '_clean' => 1,
        'n' => (int) $nested,
    ];

    $page = $this->get(route('entities.index', [1, $entityType, ...$filters]));
    $page->assertSuccessful()->assertViewHas('parent', null);

    $response = $this->getJson(route('entities.index-api', [1, $entityType, ...$filters]));
    $response->assertSuccessful()
        ->assertJsonPath('error', false)
        ->assertJsonPath('parent', null)
        ->assertJsonPath('filters.active', true);

    $expected = match ($option) {
        'exclude' => [$otherChild->entity->id, $root->entity->id],
        'none' => [$root->entity->id],
        default => [$matchingChild->entity->id],
    };
    expect(Arr::pluck($response->json('entities.data'), 'id'))->toEqualCanonicalizing($expected);

    $saved = $this->getJson(route('entities.index-api', [1, $entityType]));
    $saved->assertSuccessful()->assertJsonPath('error', false);
    expect(Arr::pluck($saved->json('entities.data'), 'id'))->toEqualCanonicalizing($expected);
})->with(['matches' => '', 'does not match' => 'exclude', 'no parent' => 'none'])
    ->with(['nested' => true, 'flat' => false]);

it('filters abilities without parents when no parent is selected', function () {
    $this->asUser()->withCampaign();

    $parent = Ability::factory()->create(['campaign_id' => 1]);
    $child = Ability::factory()->create(['campaign_id' => 1]);
    $child->entity->update(['parent_id' => $parent->entity->id]);

    $entityType = EntityType::findOrFail(config('entities.ids.ability'));
    $response = $this->getJson(route('entities.index-api', [
        1,
        $entityType,
        'parent_id_option' => 'none',
        '_clean' => 1,
    ]));

    $response->assertSuccessful()->assertJsonPath('error', false);
    expect(Arr::pluck($response->json('entities.data'), 'id'))->toBe([$parent->entity->id]);
});

it('includes nested entities in search results and marks the listing criteria active', function () {
    $this->asUser()->withCampaign();

    $parent = Ability::factory()->create(['campaign_id' => 1]);
    $child = Ability::factory()->create(['campaign_id' => 1]);
    $child->entity->update([
        'name' => 'The Tavern',
        'parent_id' => $parent->entity->id,
    ]);

    $entityType = EntityType::findOrFail(config('entities.ids.ability'));
    $response = $this->getJson(route('entities.index-api', [
        1,
        $entityType,
        'search' => 'The Tavern',
        'n' => 1,
    ]));

    $response->assertSuccessful()
        ->assertJsonPath('error', false)
        ->assertJsonPath('filters.active', true);
    expect(Arr::pluck($response->json('entities.data'), 'id'))
        ->toContain($child->entity->id);
});

it('filters entity listings by gallery and legacy image fields', function () {
    $this->asUser()->withCampaign();

    $galleryEntity = Character::factory()->create(['campaign_id' => 1]);
    $legacyEntity = Character::factory()->create(['campaign_id' => 1]);
    $imageLessEntity = Character::factory()->create(['campaign_id' => 1]);

    $galleryImage = Image::factory()->create(['campaign_id' => 1]);
    $galleryEntity->entity->updateQuietly(['image_uuid' => $galleryImage->id]);
    $legacyEntity->entity->forceFill(['image_path' => 'legacy/character.png'])->saveQuietly();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $listingUrl = fn (int $hasImage): string => route('entities.index-api', [
        1,
        $entityType,
        'has_image' => $hasImage,
        '_clean' => 1,
    ]);
    $entityIds = fn ($response): array => Arr::pluck(
        $response->json('entities.data'),
        'id',
    );

    $withImage = $this->getJson($listingUrl(1));
    $withImage->assertSuccessful();
    expect($entityIds($withImage))
        ->toContain($galleryEntity->entity->id, $legacyEntity->entity->id)
        ->not->toContain($imageLessEntity->entity->id);

    $withoutImage = $this->getJson($listingUrl(0));
    $withoutImage->assertSuccessful();
    expect($entityIds($withoutImage))
        ->toContain($imageLessEntity->entity->id)
        ->not->toContain($galleryEntity->entity->id, $legacyEntity->entity->id);
});

it('orders entity listings by entity timestamps without exposing them as columns', function (string $field, bool $descending) {
    $this->asUser()->withCampaign();

    $older = Character::factory()->create(['campaign_id' => 1]);
    $newer = Character::factory()->create(['campaign_id' => 1]);

    $older->entity->forceFill([
        'created_at' => '2020-01-01 00:00:00',
        'updated_at' => '2020-01-01 00:00:00',
    ])->saveQuietly();
    $newer->entity->forceFill([
        'created_at' => '2021-01-01 00:00:00',
        'updated_at' => '2021-01-01 00:00:00',
    ])->saveQuietly();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $response = $this->getJson(route('entities.index-api', [
        1,
        $entityType,
        'order' => $field,
        'desc' => $descending ? 1 : 0,
        '_clean' => 1,
    ]));

    $response->assertSuccessful();
    $ids = Arr::pluck($response->json('entities.data'), 'id');
    if ($descending) {
        expect(array_search($newer->entity->id, $ids, true))
            ->toBeLessThan(array_search($older->entity->id, $ids, true));
    } else {
        expect(array_search($older->entity->id, $ids, true))
            ->toBeLessThan(array_search($newer->entity->id, $ids, true));
    }
    expect(array_column($response->json('columns'), 'key'))
        ->not->toContain('created_at', 'updated_at');
    expect($response->json('i18n.createdAt'))->not->toBeEmpty();
    expect($response->json('i18n.updatedAt'))->not->toBeEmpty();
})->with([
    'created ascending' => ['created_at', false],
    'created descending' => ['created_at', true],
    'updated ascending' => ['updated_at', false],
    'updated descending' => ['updated_at', true],
]);
