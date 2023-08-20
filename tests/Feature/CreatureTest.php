<?php

it('POSTS an invalid creature form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/creatures', [])
    ->assertStatus(422)
;


it('POSTS a new creature')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/creatures', [
        'name' => fake()->name()
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
        ]
    ])
;

it('GETS all creatures')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/creatures')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
                'is_private',
            ]
        ]
    ])
;

it('GETS a specific creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ]
    ])
;


it('UPDATES a valid creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->putJson('/api/1.0/campaigns/1/creatures/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob'])
;

it('UPDATES a valid creature without a name')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->putJson('/api/1.0/campaigns/1/creatures/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic'])
;

it('DELETES a creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->delete('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(204)
;


it('DELETES am invalid creature')
    ->asUser()
    ->withCampaign()
    ->withCreatures()
    ->delete('/api/1.0/campaigns/1/creatures/100')
    ->assertStatus(404)
;

it('can\'t GET a private creature as a player')
    ->asPlayer()
    ->withCampaign()
    ->withCreatures(['is_private' => true])
    ->delete('/api/1.0/campaigns/1/creatures/1')
    ->assertStatus(403)
;
