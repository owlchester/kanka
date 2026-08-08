<?php

use App\Models\Creature;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\Race;
use App\Services\Entity\MoveService;

it('POSTS an invalid location form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/locations', [])
    ->assertStatus(422);

it('POSTS a new location')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/locations', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all locations')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->get('/api/1.0/campaigns/1/locations')
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

it('GETS a specific location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->get('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->putJson('/api/1.0/campaigns/1/locations/1', ['name' => 'Firelink Shrine'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Firelink Shrine']);

it('UPDATES a valid location without a name')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->putJson('/api/1.0/campaigns/1/locations/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->delete('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(204);

it('DELETES an invalid location')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->delete('/api/1.0/campaigns/1/locations/100')
    ->assertStatus(404);

it('can GET a location as a player')
    ->asUser()
    ->withCampaign()
    ->withLocations()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/locations/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private location as a player', function () {
    $this->asUser()
        ->withCampaign();

    Location::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/locations/1');
    expect($response->status())
        ->toBe(403);
});

it('shows creatures linked through entity locations on its connections map', function () {
    $this->asUser()->withCampaign()->withLocations()->withCreatures();

    $location = Location::first();
    $creature = Creature::first();
    $creature->entity->locations()->attach($location->id);

    $response = $this->getJson(route('entities.relations_map', [1, $location->entity, 'option' => 'related']))
        ->assertSuccessful();

    expect(collect($response->json('entities'))->pluck('id')->all())
        ->toContain($creature->entity->id);
});

it('detaches location entities without deleting them when moving a location', function () {
    $this->asUser()->withCampaign()->withCampaigns();

    $location = Location::factory()->create(['campaign_id' => 1]);
    $creature = Creature::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $race = Race::factory()->create(['campaign_id' => 1]);

    foreach ([$creature, $organisation, $race] as $model) {
        $model->entity->locations()->attach($location->id);
    }

    app(MoveService::class)
        ->entity($location->entity)
        ->campaign($location->campaign)
        ->user(auth()->user())
        ->to(2)
        ->copy(false)
        ->validate()
        ->process();

    $this->assertModelExists($location->fresh());
    $this->assertModelExists($creature->fresh());
    $this->assertModelExists($organisation->fresh());
    $this->assertModelExists($race->fresh());

    expect($location->fresh()->campaign_id)->toBe(2)
        ->and($creature->fresh()->campaign_id)->toBe(1)
        ->and($organisation->fresh()->campaign_id)->toBe(1)
        ->and($race->fresh()->campaign_id)->toBe(1);

    foreach ([$creature, $organisation, $race] as $model) {
        expect($model->fresh()->entity->locations()->whereKey($location->id)->exists())->toBeFalse();
    }
});
