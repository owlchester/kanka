<?php

it('POSTS an invalid map marker form')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_markers', [])
    ->assertStatus(422);

it('POSTS a new map marker')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_markers', [
        'name' => fake()->name(),
        'map_id' => 1,
        'longitude' => 1,
        'latitude' => 1,
        'icon' => 1,
        'shape_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'map_id',
        ],
    ]);

it('GETS all maps markers')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->get('/api/1.0/campaigns/1/maps/1/map_markers')
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

it('GETS a specific map marker')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->get('/api/1.0/campaigns/1/maps/1/map_markers/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map marker')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->putJson('/api/1.0/campaigns/1/maps/1/map_markers/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('DELETES a map marker')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_markers/1')
    ->assertStatus(204);

it('DELETES an invalid map marker')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_markers/100')
    ->assertStatus(404);

it('can GET a map marker as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapMarkers()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1/map_markers/1')
    ->assertStatus(200);
