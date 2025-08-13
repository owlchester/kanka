<?php

it('POSTS an invalid reminders form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/reminders', [])
    ->assertStatus(422);

it('POSTS a new entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->postJson('/api/1.0/campaigns/1/entities/1/reminders', [
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

it('GETS all reminders')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->get('/api/1.0/campaigns/1/entities/1/reminders')
    ->assertStatus(200)
    ->assertJsonFragment([
        'id' => 1,
    ]);

it('GETS a specific entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->get('/api/1.0/campaigns/1/entities/1/reminders/1')
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
    ->withCalendars()
    ->withReminders()
    ->putJson('/api/1.0/campaigns/1/entities/1/reminders/1', ['length' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['length' => 2]);

it('DELETES an entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->delete('/api/1.0/campaigns/1/entities/1/reminders/1')
    ->assertStatus(204);

it('DELETES an invalid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->delete('/api/1.0/campaigns/1/entities/1/reminders/100')
    ->assertStatus(404);
