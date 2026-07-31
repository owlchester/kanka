<?php

use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Location;

function makeGadgetEntityType(): EntityType
{
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

    return $entityType;
}

it('saves locations when creating a custom entity', function () {
    $this->asUser()->withCampaign(['boost_count' => 4])->withLocations();

    $entityType = makeGadgetEntityType();
    $location = Location::first();

    $this->post(route('entities.store', [1, $entityType]), [
        'name' => 'Widget',
        'entity_id' => 0,
        'save_locations' => 1,
        'locations' => [$location->id],
    ])->assertRedirect();

    $entity = Entity::where('name', 'Widget')->firstOrFail();

    expect($entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$location->id]);
});

it('saves locations when editing a custom entity', function () {
    $this->asUser()->withCampaign(['boost_count' => 4])->withLocations();

    $entityType = makeGadgetEntityType();
    $location = Location::first();

    $entity = new Entity([
        'campaign_id' => 1,
        'entity_id' => 0,
        'name' => 'Widget',
    ]);
    $entity->type_id = $entityType->id;
    $entity->save();

    $this->patch(route('entities.update', [1, $entity]), [
        'name' => 'Widget',
        'save_locations' => 1,
        'locations' => [$location->id],
    ])->assertRedirect();

    expect($entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$location->id]);
});
