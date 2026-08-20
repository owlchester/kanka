<?php

use App\Models\EntityType;
use App\Models\Journal;
use App\Models\Location;

it('POSTS an invalid journal form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/journals', [])
    ->assertStatus(422);

it('POSTS a new journal')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/journals', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all journals')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->get('/api/1.0/campaigns/1/journals')
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

it('GETS a specific journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->get('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->putJson('/api/1.0/campaigns/1/journals/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid journal without a name')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->putJson('/api/1.0/campaigns/1/journals/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->delete('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(204);

it('DELETES an invalid journal')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->delete('/api/1.0/campaigns/1/journals/100')
    ->assertStatus(404);

it('can GET a journal as a player')
    ->asUser()
    ->withCampaign()
    ->withJournals()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/journals/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private journal as a player', function () {
    $this->asUser()
        ->withCampaign();

    Journal::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/journals/1');
    expect($response->status())
        ->toBe(403);
});

it('creates and updates journal locations through the API', function () {
    $this->asUser()->withCampaign()->withJournals()->withLocations();

    $locations = Location::all();
    $response = $this->postJson('/api/1.0/campaigns/1/journals', [
        'name' => 'Located journal',
        'locations' => [$locations[0]->id, $locations[1]->id],
    ])->assertCreated();

    $journal = Journal::findOrFail($response->json('data.id'));
    expect($journal->entity->locations()->pluck('locations.id')->sort()->values()->all())
        ->toBe([$locations[0]->id, $locations[1]->id]);
    expect($response->json('data.locations'))->toContain($locations[0]->id, $locations[1]->id);
    expect($response->json('data'))->not->toHaveKey('location_id');

    $this->putJson('/api/1.0/campaigns/1/journals/' . $journal->id, [
        'name' => $journal->entity->name,
        'locations' => [$locations[2]->id],
    ])->assertSuccessful();

    expect($journal->fresh()->entity->locations()->pluck('locations.id')->all())
        ->toBe([$locations[2]->id]);
});

it('saves journal locations through the web form', function () {
    $this->asUser()->withCampaign()->withJournals()->withLocations();

    $locations = Location::all();
    $this->post(route('journals.store', [1]), [
        'name' => 'Web journal',
        'save_locations' => 1,
        'locations' => [$locations[0]->id, $locations[1]->id],
    ])->assertRedirect();

    $journal = Journal::where('name', 'Web journal')->firstOrFail();
    expect($journal->entity->locations()->pluck('locations.id')->sort()->values()->all())
        ->toBe([$locations[0]->id, $locations[1]->id]);
});

it('filters journals by locations', function () {
    $this->asUser()->withCampaign()->withJournals()->withLocations();

    $journal = Journal::first();
    $location = Location::first();
    $journal->entity->locations()->attach($location->id);
    $entityType = EntityType::findOrFail(config('entities.ids.journal'));

    $response = $this->getJson(route('entities.index-api', [1, $entityType, 'locations' => [$location->id]]))
        ->assertSuccessful();

    expect(collect($response->json('entities.data'))->pluck('id')->all())
        ->toBe([$journal->entity->id]);
});

it('bulk adds and removes journal locations', function () {
    $this->asUser()->withCampaign()->withJournals()->withLocations();

    $journal = Journal::first();
    $location = Location::first();
    $payload = [
        'entity' => 'journals',
        'entity_type' => config('entities.ids.journal'),
        'models' => (string) $journal->id,
        'datagrid-action' => 'batch',
        'locations' => [$location->id],
    ];

    $this->post(route('bulk.process', [1]), $payload + ['bulk-locations' => 'add'])->assertRedirect();
    expect($journal->entity->locations()->pluck('locations.id')->all())->toBe([$location->id]);

    $this->post(route('bulk.process', [1]), $payload + ['bulk-locations' => 'remove'])->assertRedirect();
    expect($journal->fresh()->entity->locations()->pluck('locations.id')->all())->toBe([]);
});

it('shows journal locations in both connection directions', function () {
    $this->asUser()->withCampaign()->withJournals()->withLocations();

    $journal = Journal::first();
    $location = Location::first();
    $journal->entity->locations()->attach($location->id);

    $journalMap = $this->getJson(route('entities.relations_map', [1, $journal->entity, 'option' => 'related']))
        ->assertSuccessful();
    expect(collect($journalMap->json('entities'))->pluck('id')->all())->toContain($location->entity->id);

    $locationMap = $this->getJson(route('entities.relations_map', [1, $location->entity, 'option' => 'related']))
        ->assertSuccessful();
    expect(collect($locationMap->json('entities'))->pluck('id')->all())->toContain($journal->entity->id);
});
