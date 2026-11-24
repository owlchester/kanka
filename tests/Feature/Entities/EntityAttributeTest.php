<?php

use App\Enums\AttributeType;
use App\Models\Attribute;

it('POSTS an invalid attributes form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/attributes', [])
    ->assertStatus(422);

it('POSTS a new attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/attributes', [
        'name' => fake()->name(),
        'type_id' => 1,
        'api_key' => '1',
        'value' => 'Entity: [entity:2]',
        'is_hidden' => 0,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all attributes')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->get('/api/1.0/campaigns/1/entities/1/attributes')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->get('/api/1.0/campaigns/1/entities/1/attributes/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->putJson('/api/1.0/campaigns/1/entities/1/attributes/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid attribute without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->putJson('/api/1.0/campaigns/1/entities/1/attributes/1', ['value' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['value' => 'Magic']);

it('PATCHES an existing attribute without changing its type when type_id is omitted', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $attribute = Attribute::factory()->create([
        'entity_id' => 1,
        'type_id' => AttributeType::Checkbox->value,
        'name' => 'Existing checkbox',
        'value' => 'Old value',
    ]);

    $this->patchJson('/api/1.0/campaigns/1/entities/1/attributes', [
        'attribute' => [[
            'id' => $attribute->id,
            'name' => 'Updated checkbox',
            'value' => 'New value',
        ]],
    ])->assertSuccessful();

    expect($attribute->fresh()->name)->toBe('Updated checkbox')
        ->and($attribute->fresh()->value)->toBe('New value')
        ->and($attribute->fresh()->type_id)->toBe(AttributeType::Checkbox);

    $this->patchJson('/api/1.0/campaigns/1/entities/1/attributes', [
        'attribute' => [[
            'id' => $attribute->id,
            'name' => 'Updated checkbox',
            'type_id' => AttributeType::Standard->value,
            'value' => 'Explicit type',
        ]],
    ])->assertSuccessful();

    expect($attribute->fresh()->type_id)->toBe(AttributeType::Standard)
        ->and($attribute->fresh()->value)->toBe('Explicit type');
});

it('DELETES an attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->delete('/api/1.0/campaigns/1/entities/1/attributes/1')
    ->assertStatus(204);

it('DELETES an invalid attribute')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAttributes()
    ->delete('/api/1.0/campaigns/1/entities/1/attributes/100')
    ->assertStatus(404);
