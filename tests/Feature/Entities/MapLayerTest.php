<?php

it('POSTS an invalid map layer form')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_layers', [])
    ->assertStatus(422);

it('POSTS a new map layer')
    ->asUser()
    ->withCampaign()
    ->withImages()
    ->withMaps()
    ->postJson('/api/1.0/campaigns/1/maps/1/map_layers', [
        'name' => fake()->name(),
        'image_uuid' => '1',
        'map_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'map_id',
        ],
    ]);

it('GETS all maps layers')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers')
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

it('GETS a specific map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->putJson('/api/1.0/campaigns/1/maps/1/map_layers/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('DELETES a map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(204);

it('DELETES an invalid map layer')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->delete('/api/1.0/campaigns/1/maps/1/map_layers/100')
    ->assertStatus(404);

it('can GET a map layer as a player')
    ->asUser()
    ->withCampaign()
    ->withMaps()
    ->withMapLayers()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/maps/1/map_layers/1')
    ->assertStatus(200);
