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
