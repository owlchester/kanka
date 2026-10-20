<?php

use App\Enums\EntityAssetType;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\EntityTag;
use App\Models\EntityType;
use App\Models\Post;
use App\Models\Tag;

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

    foreach (['has_image', 'template', 'has_entry', 'has_entity_files', 'has_posts', 'has_attributes'] as $filter) {
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

    $filters = ['tags' => [$firstTag->id], 'tags_option' => 'exclude'];
    expect($childIds($filters))
        ->toContain($second->id, $untagged->id)
        ->not->toContain($first->id, $both->id);
    expect($entityIds($filters))
        ->toContain($second->entity->id, $untagged->entity->id)
        ->not->toContain($first->entity->id, $both->entity->id);

    $filters = ['tags' => [], 'tags_option' => 'none'];
    expect($childIds($filters))->toBe([$untagged->id]);
    expect($entityIds($filters))->toBe([$untagged->entity->id]);
});
