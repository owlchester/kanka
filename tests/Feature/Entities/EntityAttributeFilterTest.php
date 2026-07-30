<?php

use App\Enums\AttributeType;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Entity;

it('filters unchecked checkbox attributes with a zero value without broadening other attributes', function () {
    $this->asUser()->withCampaign();

    $uncheckedCheckbox = Character::factory()->create(['campaign_id' => 1]);
    $checkedCheckbox = Character::factory()->create(['campaign_id' => 1]);
    $zeroValue = Character::factory()->create(['campaign_id' => 1]);
    $otherValue = Character::factory()->create(['campaign_id' => 1]);

    Attribute::factory()->create([
        'entity_id' => $uncheckedCheckbox->entity->id,
        'name' => 'checky',
        'type_id' => AttributeType::Checkbox,
        'value' => null,
    ]);
    Attribute::factory()->create([
        'entity_id' => $checkedCheckbox->entity->id,
        'name' => 'checky',
        'type_id' => AttributeType::Checkbox,
        'value' => '1',
    ]);
    Attribute::factory()->create([
        'entity_id' => $zeroValue->entity->id,
        'name' => 'checky',
        'type_id' => AttributeType::Standard,
        'value' => '0',
    ]);
    Attribute::factory()->create([
        'entity_id' => $otherValue->entity->id,
        'name' => 'checky',
        'type_id' => AttributeType::Standard,
        'value' => '1',
    ]);

    $entityIds = Entity::query()
        ->filter(['attribute_name' => 'checky', 'attribute_value' => '0'])
        ->pluck('entities.id');

    expect($entityIds->all())
        ->toContain($uncheckedCheckbox->entity->id, $zeroValue->entity->id)
        ->not->toContain($checkedCheckbox->entity->id, $otherValue->entity->id);
});

it('excludes attribute values prefixed with an exclamation mark', function () {
    $this->asUser()->withCampaign();

    $matchingValue = Character::factory()->create(['campaign_id' => 1]);
    $otherValue = Character::factory()->create(['campaign_id' => 1]);
    $emptyValue = Character::factory()->create(['campaign_id' => 1]);

    Attribute::factory()->create([
        'entity_id' => $matchingValue->entity->id,
        'name' => 'checky',
        'value' => '1',
    ]);
    Attribute::factory()->create([
        'entity_id' => $otherValue->entity->id,
        'name' => 'checky',
        'value' => '0',
    ]);
    Attribute::factory()->create([
        'entity_id' => $emptyValue->entity->id,
        'name' => 'checky',
        'value' => null,
    ]);

    $entityIds = Entity::query()
        ->filter(['attribute_name' => 'checky', 'attribute_value' => '!1'])
        ->pluck('entities.id');

    expect($entityIds->all())
        ->toContain($otherValue->entity->id, $emptyValue->entity->id)
        ->not->toContain($matchingValue->entity->id);
});
