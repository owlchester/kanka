<?php

use App\Models\MapGroup;

it('POSTS an invalid map group form')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_groups', [])
    ->assertStatus(422);

it('POSTS a new map group')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_groups', [
        'name' => fake()->name(),
        'map_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'map_id',
        ],
    ]);

it('creates a group on the URL map while ignoring legacy map_id', function () {
    $this->asUser()->withCampaign()->withMaps()
        ->postJson('/api/1.0/campaigns/1/maps/1/map_groups', [
            'name' => 'Map-owned group',
            'map_id' => 999,
            'is_shown' => true,
        ])
        ->assertCreated()
        ->assertJsonPath('data.map_id', 1)
        ->assertJsonPath('data.is_shown', true);
});

it('creates a group without a body map_id')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_groups', ['name' => 'No body map'])
    ->assertCreated()
    ->assertJsonPath('data.map_id', 1);

it('GETS all maps groups')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->get('/api/1.0/campaigns/1/maps/1/map_groups')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific map group')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->get('/api/1.0/campaigns/1/maps/1/map_groups/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map group')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->putJson('/api/1.0/campaigns/1/maps/1/map_groups/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('ignores legacy map_id on group update and returns 404 for another map group', function () {
    $this->asUser()->withCampaign()->withMaps()->withMapGroups()
        ->putJson('/api/1.0/campaigns/1/maps/1/map_groups/1', [
            'name' => 'Updated group',
            'map_id' => 999,
            'is_shown' => true,
        ])
        ->assertSuccessful()
        ->assertJsonPath('data.map_id', 1)
        ->assertJsonPath('data.is_shown', true);

    $otherGroup = MapGroup::factory()->create(['map_id' => 2]);
    $this->getJson("/api/1.0/campaigns/1/maps/1/map_groups/{$otherGroup->id}")->assertNotFound();
    $this->putJson("/api/1.0/campaigns/1/maps/1/map_groups/{$otherGroup->id}", ['name' => 'Nope'])->assertNotFound();
    $this->deleteJson("/api/1.0/campaigns/1/maps/1/map_groups/{$otherGroup->id}")->assertNotFound();
});

it('DELETES a map group')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->delete('/api/1.0/campaigns/1/maps/1/map_groups/1')
    ->assertStatus(204);

it('DELETES an invalid map group')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->delete('/api/1.0/campaigns/1/maps/1/map_groups/100')
    ->assertStatus(404);

it('can GET a map group as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapGroups()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1/map_groups/1')
    ->assertStatus(200);
