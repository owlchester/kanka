<?php

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
