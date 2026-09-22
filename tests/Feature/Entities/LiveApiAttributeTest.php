<?php

use App\Models\Attribute;
use App\Models\Character;
use App\Http\Middleware\ReplicationSwitcher;

it('forbids guests from mutating live attributes', function () {
    $this->asUser()->withCampaign([
        'visibility_id' => 3,
    ])->withCharacters()->withAttributes();

    $entity = Character::findOrFail(1)->entity;
    $attribute = Attribute::where('entity_id', $entity->id)->firstOrFail();
    $originalName = $attribute->name;

    auth()->guard('api')->forgetUser();
    $this->withoutMiddleware(ReplicationSwitcher::class);

    $this->postJson(route('entities.attributes.live-api.create', [$entity->campaign, $entity]), [
        'name' => 'Guest attribute',
    ])->assertForbidden();

    $this->postJson(route('entities.attributes.live-api.update', [$entity->campaign, $entity, $attribute]), [
        'name' => 'Updated by guest',
    ])->assertForbidden();

    $this->postJson(route('entities.attributes.live-api.delete', [$entity->campaign, $entity, $attribute]))
        ->assertForbidden();

    expect(Attribute::where('name', 'Guest attribute')->exists())->toBeFalse()
        ->and($attribute->fresh()->name)->toBe($originalName);
    $this->assertModelExists($attribute->fresh());
});

it('forbids players without edit permission from mutating live attributes', function () {
    $this->asUser()->withCampaign()->withCharacters()->withAttributes();

    $entity = Character::findOrFail(1)->entity;
    $attribute = Attribute::where('entity_id', $entity->id)->firstOrFail();
    $originalName = $attribute->name;

    $this->asPlayer();

    $this->postJson(route('entities.attributes.live-api.create', [$entity->campaign, $entity]), [
        'name' => 'Player attribute',
    ])->assertForbidden();

    $this->postJson(route('entities.attributes.live-api.update', [$entity->campaign, $entity, $attribute]), [
        'name' => 'Updated by player',
    ])->assertForbidden();

    $this->postJson(route('entities.attributes.live-api.delete', [$entity->campaign, $entity, $attribute]))
        ->assertForbidden();

    expect(Attribute::where('name', 'Player attribute')->exists())->toBeFalse()
        ->and($attribute->fresh()->name)->toBe($originalName);
    $this->assertModelExists($attribute->fresh());
});

it('allows owners to mutate live attributes without changing their entity', function () {
    $this->asUser()->withCampaign()->withCharacters()->withAttributes();

    $entity = Character::findOrFail(1)->entity;
    $otherEntity = Character::factory()->create()->entity;
    $attribute = Attribute::where('entity_id', $entity->id)->firstOrFail();

    $this->postJson(route('entities.attributes.live-api.create', [$entity->campaign, $entity]), [
        'name' => 'Owner attribute',
        'value' => 'Value',
        'entity_id' => $otherEntity->id,
    ])->assertSuccessful();

    $created = Attribute::where('name', 'Owner attribute')->firstOrFail();
    expect($created->entity_id)->toBe($entity->id);

    $this->postJson(route('entities.attributes.live-api.update', [$entity->campaign, $entity, $attribute]), [
        'name' => 'Updated attribute',
        'entity_id' => $otherEntity->id,
    ])->assertSuccessful();

    expect($attribute->fresh()->name)->toBe('Updated attribute')
        ->and($attribute->fresh()->entity_id)->toBe($entity->id);

    $this->postJson(route('entities.attributes.live-api.delete', [$entity->campaign, $entity, $attribute]))
        ->assertNoContent();

    expect(Attribute::find($attribute->id))->toBeNull();
    $this->assertModelExists($created);
});

it('cannot mutate an attribute through another entity route', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Character::findOrFail(1)->entity;
    $otherEntity = Character::factory()->create()->entity;
    $attribute = Attribute::factory()->create([
        'entity_id' => $otherEntity->id,
    ]);
    $originalName = $attribute->name;

    $this->postJson(route('entities.attributes.live-api.update', [$entity->campaign, $entity, $attribute]), [
        'name' => 'Cross-entity update',
    ])->assertNotFound();

    $this->postJson(route('entities.attributes.live-api.delete', [$entity->campaign, $entity, $attribute]))
        ->assertNotFound();

    expect($attribute->fresh()->name)->toBe($originalName);
    $this->assertModelExists($attribute->fresh());
});
