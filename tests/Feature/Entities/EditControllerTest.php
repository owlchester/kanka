<?php

use App\Models\Entity;
use App\Models\EntityType;

it('pre-fills the privacy toggle as private when editing a private custom module entity', function () {
    $this->asUser()->withCampaign();

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

    $entity = new Entity([
        'campaign_id' => 1,
        'entity_id' => 0,
        'name' => 'Secret Gadget',
        'is_private' => true,
    ]);
    $entity->type_id = $entityType->id;
    $entity->save();

    $this->get(route('entities.edit', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('private: true', false);
});
