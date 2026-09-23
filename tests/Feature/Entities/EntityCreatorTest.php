<?php

use App\Models\Entity;
use App\Models\EntityType;

it('rejects a missing parent when quick creating a custom entity', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);

    $entityType = new EntityType([
        'code' => 'gadget',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $entityType->campaign_id = 1;
    $entityType->singular = 'Gadget';
    $entityType->plural = 'Gadgets';
    $entityType->icon = 'fa-solid fa-gear';
    $entityType->save();

    $this->postJson(route('entity-creator.store', [1, $entityType]), [
        'name' => 'Child gadget',
        'parent_id' => 999999,
        '_target' => 'parent_id',
    ])->assertJsonValidationErrors('parent_id');

    expect(Entity::where('name', 'Child gadget')->exists())->toBeFalse();
});

it('quick creates a custom entity with a valid parent', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);

    $entityType = new EntityType([
        'code' => 'gadget',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $entityType->campaign_id = 1;
    $entityType->singular = 'Gadget';
    $entityType->plural = 'Gadgets';
    $entityType->icon = 'fa-solid fa-gear';
    $entityType->save();

    $parent = new Entity([
        'name' => 'Parent gadget',
    ]);
    $parent->campaign_id = 1;
    $parent->type_id = $entityType->id;
    $parent->save();

    $this->postJson(route('entity-creator.store', [1, $entityType]), [
        'name' => 'Child gadget',
        'parent_id' => $parent->id,
        '_target' => 'parent_id',
    ])->assertSuccessful();

    $child = Entity::where('name', 'Child gadget')->firstOrFail();

    expect($child->parent_id)->toBe($parent->id);
});
