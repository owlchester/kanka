<?php

use App\Models\EntityType;
use App\Models\Family;
use App\Models\Location;

it('POSTS an invalid family form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/families', [])
    ->assertStatus(422);

it('POSTS a new family')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/families', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all families')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->get('/api/1.0/campaigns/1/families')
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

it('GETS a specific family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->get('/api/1.0/campaigns/1/families/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->putJson('/api/1.0/campaigns/1/families/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid family without a name')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->putJson('/api/1.0/campaigns/1/families/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->delete('/api/1.0/campaigns/1/families/1')
    ->assertStatus(204);

it('DELETES an invalid family')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->delete('/api/1.0/campaigns/1/families/100')
    ->assertStatus(404);

it('can GET a family as a player')
    ->asUser()
    ->withCampaign()
    ->withFamilies()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/families/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private family as a player', function () {
    $this->asUser()
        ->withCampaign();

    Family::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/families/1');
    expect($response->status())
        ->toBe(403);
});

it('POSTS a new family with locations through the API', function () {
    $this->asUser()->withCampaign()->withLocations();

    $locations = Location::all();

    $response = $this->postJson('/api/1.0/campaigns/1/families', [
        'name' => fake()->name(),
        'locations' => [$locations[0]->id, $locations[1]->id],
    ]);
    $response->assertStatus(201);

    $family = Family::findOrFail($response->json('data.id'));

    expect($family->entity->locations()->pluck('locations.id')->sort()->values()->toArray())
        ->toBe([$locations[0]->id, $locations[1]->id]);
    expect($response->json('data.locations'))
        ->toContain($locations[0]->id, $locations[1]->id);
});

it('UPDATES a family\'s locations through the API', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $family = Family::first();
    $locations = Location::all();

    $family->entity->locations()->attach($locations[0]->id);

    $response = $this->putJson('/api/1.0/campaigns/1/families/' . $family->id, [
        'name' => $family->entity->name,
        'locations' => [$locations[1]->id, $locations[2]->id],
    ]);
    $response->assertStatus(200);

    expect($family->entity->locations()->pluck('locations.id')->sort()->values()->toArray())
        ->toBe([$locations[1]->id, $locations[2]->id]);
});

it('saves locations when creating a family through the web form', function () {
    $this->asUser()->withCampaign()->withLocations();

    $locations = Location::all();

    $this->post(route('families.store', [1]), [
        'name' => 'Adams',
        'save_locations' => 1,
        'locations' => [$locations[0]->id, $locations[1]->id],
    ])->assertRedirect();

    $family = Family::where('name', 'Adams')->firstOrFail();

    expect($family->entity->locations()->pluck('locations.id')->sort()->values()->toArray())
        ->toBe([$locations[0]->id, $locations[1]->id]);
});

it('saves locations when editing a family through the web form', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $family = Family::first();
    $locations = Location::all();

    $family->entity->locations()->attach($locations[0]->id);

    $this->patch(route('families.update', [1, $family->id]), [
        'name' => $family->entity->name,
        'save_locations' => 1,
        'locations' => [$locations[1]->id],
    ])->assertRedirect();

    expect($family->entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$locations[1]->id]);
});

it('bulk adds and removes family locations', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $family = Family::first();
    $locations = Location::all();

    $this->post(route('bulk.process', [1]), [
        'entity' => 'families',
        'entity_type' => config('entities.ids.family'),
        'models' => (string) $family->id,
        'datagrid-action' => 'batch',
        'locations' => [$locations[0]->id],
        'bulk-locations' => 'add',
    ])->assertRedirect();

    expect($family->entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$locations[0]->id]);

    $this->post(route('bulk.process', [1]), [
        'entity' => 'families',
        'entity_type' => config('entities.ids.family'),
        'models' => (string) $family->id,
        'datagrid-action' => 'batch',
        'locations' => [$locations[0]->id],
        'bulk-locations' => 'remove',
    ])->assertRedirect();

    expect($family->entity->locations()->pluck('locations.id')->toArray())
        ->toBe([]);
});

it('filters families by locations', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $families = Family::all();
    $locations = Location::all();

    $families[0]->entity->locations()->attach($locations[0]->id);

    $entityType = EntityType::findOrFail(config('entities.ids.family'));

    $response = $this->getJson(route('entities.index-api', [1, $entityType, 'locations' => [$locations[0]->id]]));
    $response->assertSuccessful();

    $ids = collect($response->json('entities.data'))->pluck('id')->toArray();
    expect($ids)->toBe([$families[0]->entity->id]);
});

it('shows a family\'s locations on its connections map', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $family = Family::first();
    $location = Location::first();
    $family->entity->locations()->attach($location->id);

    $response = $this->getJson(route('entities.relations_map', [1, $family->entity, 'option' => 'related']));
    $response->assertSuccessful();

    $entityIds = collect($response->json('entities'))->pluck('id')->toArray();
    expect($entityIds)->toContain($location->entity->id);
});

it('shows families located there on a location\'s connections map', function () {
    $this->asUser()->withCampaign()->withFamilies()->withLocations();

    $family = Family::first();
    $location = Location::first();
    $family->entity->locations()->attach($location->id);

    $response = $this->getJson(route('entities.relations_map', [1, $location->entity, 'option' => 'related']));
    $response->assertSuccessful();

    $entityIds = collect($response->json('entities'))->pluck('id')->toArray();
    expect($entityIds)->toContain($family->entity->id);
});
