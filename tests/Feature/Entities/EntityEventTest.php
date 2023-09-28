<?php

it('POSTS an invalid entity_events form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_events', [])
    ->assertStatus(422)
;


it('POSTS a new entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_events', [
        'calendar_id' => 1,
        'entity_id' => 1,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 2,
        'is_recurring' => true,
        'recurring_until' => 22
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'calendar_id',
        ]
    ])
;

it('GETS all entity_events')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->get('/api/1.0/campaigns/1/entities/1/entity_events')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ]
        ]
    ])
;

it('GETS a specific entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->get('/api/1.0/campaigns/1/entities/1/entity_events/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ]
    ])
;


it('UPDATES a valid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_events/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob'])
;

it('UPDATES a valid entity event without a name')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_events/1', ['value' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['value' => 'Magic'])
;

it('DELETES an entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_events/1')
    ->assertStatus(204)
;


it('DELETES an invalid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_events/100')
    ->assertStatus(404)
;
