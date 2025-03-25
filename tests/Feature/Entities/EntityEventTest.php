<?php

it('POSTS an invalid entity_events form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_events', [])
    ->assertStatus(422);

it('POSTS a new entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_events', [
        'calendar_id' => 1,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 2,
        'visibility_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'calendar_id',
        ],
    ]);

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
                'calendar_id',
            ],
        ],
    ]);

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
            'calendar_id',
        ],
    ]);

it('UPDATES a valid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_events/1', ['length' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['length' => 2]);

it('DELETES an entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_events/1')
    ->assertStatus(204);

it('DELETES an invalid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withEntityEvents()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_events/100')
    ->assertStatus(404);
