<?php

use App\Enums\EntityAssetType;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Services\Entity\AliasService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

it('rejects aliases that exceed the campaign limit when saving an entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    request()->merge(['_boosted' => '0']);
    config(['limits.campaigns.aliases' => 2]);

    $existingEntity = Entity::findOrFail(1);
    EntityAsset::factory()->count(2)->create([
        'entity_id' => $existingEntity->id,
        'type_id' => EntityAssetType::alias,
    ]);
    $entity = Entity::findOrFail(1)->replicate(['id']);
    $entity->name = 'New entity';
    $entity->save();

    $request = Request::create('/', 'POST', [
        'aliases' => json_encode([
            ['id' => -1, 'name' => 'One too many'],
        ]),
    ]);

    expect(fn () => app(AliasService::class)->entity($entity)->request($request)->save())
        ->toThrow(ValidationException::class);

    expect($existingEntity->aliases()->count())->toBe(2);
});

it('counts aliases hidden from the current user toward the campaign limit', function () {
    $this->asUser()->withCampaign()->withCharacters();
    config(['limits.campaigns.aliases' => 2]);

    $hiddenOwner = Entity::findOrFail(1);
    EntityAsset::factory()->create([
        'entity_id' => $hiddenOwner->id,
        'type_id' => EntityAssetType::alias,
        'visibility_id' => 4,
        'created_by' => 2,
    ]);
    $entity = $hiddenOwner->replicate(['id']);
    $entity->name = 'New entity';
    $entity->save();
    $request = Request::create('/', 'POST', [
        'aliases' => json_encode([
            ['id' => -1, 'name' => 'Would exceed limit one'],
            ['id' => -2, 'name' => 'Would exceed limit two'],
        ]),
    ]);

    expect(fn () => app(AliasService::class)->entity($entity)->request($request)->save())
        ->toThrow(ValidationException::class);
});

it('allows saving an entity without adding aliases when the campaign is already over the limit', function () {
    $this->asUser()->withCampaign()->withCharacters();
    request()->merge(['_boosted' => '0']);
    config(['limits.campaigns.aliases' => 2]);

    $existingEntity = Entity::findOrFail(1);
    EntityAsset::factory()->count(3)->create([
        'entity_id' => $existingEntity->id,
        'type_id' => EntityAssetType::alias,
    ]);

    $entity = $existingEntity->replicate(['id']);
    $entity->name = 'Alias-free entity';
    $entity->save();

    $request = Request::create('/', 'POST', ['aliases' => '[]']);

    expect(fn () => app(AliasService::class)->entity($entity)->request($request)->save())
        ->not->toThrow(ValidationException::class);
});
