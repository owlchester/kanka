<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Entity\StandardEntityCreationService;

it('POSTS an invalid character form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [])
    ->assertStatus(422);

it('POSTS a new character')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('links a newly created character to its entity', function () {
    $this->asUser()->withCampaign();

    $response = $this->postJson('/api/1.0/campaigns/1/characters', [
        'name' => 'Entity First',
    ]);
    $response->assertCreated();

    $data = $response->json('data');
    $character = Character::findOrFail($data['id']);

    expect($character->entity->id)->toBe($data['entity_id']);
    expect($character->entity->entity_id)->toBe($character->id);
    expect($character->entity->created_by)->toBe(auth()->id());
});

it('rolls back an entity when its child cannot be created', function () {
    $this->asUser()->withCampaign();

    $entityType = Mockery::mock(EntityType::class)->makePartial();
    $entityType->id = config('entities.ids.character');
    $entityType->code = 'character';
    $entityType->shouldReceive('isStandard')->andReturnTrue();
    $entityType->shouldReceive('hasEntity')->once()->andReturnTrue();
    $entityType->shouldReceive('getMiscClass')
        ->once()
        ->andThrow(new RuntimeException('Child creation failed'));

    expect(fn () => app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($entityType)
        ->create(['name' => 'Rolled Back']))
        ->toThrow(RuntimeException::class);

    expect(Entity::where('name', 'Rolled Back')->exists())->toBeFalse();
});

it('POSTS a public character when privacy is null')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
        'is_private' => null,
    ])
    ->assertStatus(201)
    ->assertJsonFragment(['is_private' => false]);

it('GETS all characters')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->get('/api/1.0/campaigns/1/characters')
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

it('GETS a specific character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->get('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->putJson('/api/1.0/campaigns/1/characters/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid character without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->putJson('/api/1.0/campaigns/1/characters/1', ['type' => 'character'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'character']);

it('DELETES a character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->delete('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(204);

it('DELETES an invalid character')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->delete('/api/1.0/campaigns/1/characters/100')
    ->assertStatus(404);

it('can GET a character as a player')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/characters/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private character as a player', function () {
    $this->asUser()
        ->withCampaign();

    Character::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/characters/1');
    expect($response->status())
        ->toBe(403);
});
