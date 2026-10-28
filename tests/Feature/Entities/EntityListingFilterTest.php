<?php

use App\Models\Character;
use App\Models\EntityType;
use App\Models\Image;
use Illuminate\Support\Arr;

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
