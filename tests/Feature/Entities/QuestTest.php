<?php

use App\Models\EntityType;
use App\Models\Location;
use App\Models\Quest;

it('POSTS an invalid quest form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/quests', [])
    ->assertStatus(422);

it('POSTS a new quest')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/quests', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all quests')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->get('/api/1.0/campaigns/1/quests')
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

it('GETS a specific quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->get('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->putJson('/api/1.0/campaigns/1/quests/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid quest without a name')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->putJson('/api/1.0/campaigns/1/quests/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->delete('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(204);

it('DELETES an invalid quest')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->delete('/api/1.0/campaigns/1/quests/100')
    ->assertStatus(404);

it('can GET a quest as a player')
    ->asUser()
    ->withCampaign()
    ->withQuests()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/quests/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private quest as a player', function () {
    $this->asUser()
        ->withCampaign();

    Quest::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/quests/1');
    expect($response->status())
        ->toBe(403);
});

it('creates and updates quest locations through the API', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $locations = Location::all();
    $response = $this->postJson('/api/1.0/campaigns/1/quests', [
        'name' => 'Located quest',
        'locations' => [$locations[0]->id, $locations[1]->id],
    ])->assertCreated();

    $quest = Quest::findOrFail($response->json('data.id'));
    expect($quest->entity->locations()->pluck('locations.id')->sort()->values()->all())
        ->toBe([$locations[0]->id, $locations[1]->id]);
    expect($response->json('data.locations'))->toContain($locations[0]->id, $locations[1]->id);
    expect($response->json('data'))->not->toHaveKey('location_id');

    $this->putJson('/api/1.0/campaigns/1/quests/' . $quest->id, [
        'name' => $quest->name,
        'locations' => [$locations[2]->id],
    ])->assertSuccessful();

    expect($quest->fresh()->entity->locations()->pluck('locations.id')->all())
        ->toBe([$locations[2]->id]);
});

it('saves quest locations through the web form', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $locations = Location::all();
    $this->post(route('quests.store', [1]), [
        'name' => 'Web quest',
        'save_locations' => 1,
        'locations' => [$locations[0]->id, $locations[1]->id],
    ])->assertRedirect();

    $quest = Quest::where('name', 'Web quest')->firstOrFail();
    expect($quest->entity->locations()->pluck('locations.id')->sort()->values()->all())
        ->toBe([$locations[0]->id, $locations[1]->id]);
});

it('filters quests by locations', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $quest = Quest::first();
    $location = Location::first();
    $quest->entity->locations()->attach($location->id);
    $entityType = EntityType::findOrFail(config('entities.ids.quest'));

    $response = $this->getJson(route('entities.index-api', [1, $entityType, 'locations' => [$location->id]]))
        ->assertSuccessful();

    expect(collect($response->json('entities.data'))->pluck('id')->all())
        ->toBe([$quest->entity->id]);
});

it('bulk adds and removes quest locations', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $quest = Quest::first();
    $location = Location::first();
    $payload = [
        'entity' => 'quests',
        'entity_type' => config('entities.ids.quest'),
        'models' => (string) $quest->id,
        'datagrid-action' => 'batch',
        'locations' => [$location->id],
    ];

    $this->post(route('bulk.process', [1]), $payload + ['bulk-locations' => 'add'])->assertRedirect();
    expect($quest->entity->locations()->pluck('locations.id')->all())->toBe([$location->id]);

    $this->post(route('bulk.process', [1]), $payload + ['bulk-locations' => 'remove'])->assertRedirect();
    expect($quest->fresh()->entity->locations()->pluck('locations.id')->all())->toBe([]);
});

it('lists location quests through entity locations', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $quest = Quest::first();
    $location = Location::first();
    $quest->entity->locations()->attach($location->id);

    expect($location->allQuests()->pluck('quests.id')->all())->toContain($quest->id);
});

it('shows quest locations in both connection directions', function () {
    $this->asUser()->withCampaign()->withQuests()->withLocations();

    $quest = Quest::first();
    $location = Location::first();
    $quest->entity->locations()->attach($location->id);

    $questMap = $this->getJson(route('entities.relations_map', [1, $quest->entity, 'option' => 'related']))
        ->assertSuccessful();
    expect(collect($questMap->json('entities'))->pluck('id')->all())->toContain($location->entity->id);

    $locationMap = $this->getJson(route('entities.relations_map', [1, $location->entity, 'option' => 'related']))
        ->assertSuccessful();
    expect(collect($locationMap->json('entities'))->pluck('id')->all())->toContain($quest->entity->id);
});
