<?php

it('POSTS an invalid timeline element element form')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->postJson('/api/1.0/campaigns/1/timelines/1/timeline_elements', [])
    ->assertStatus(422);

it('POSTS a new timeline element')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->postJson('/api/1.0/campaigns/1/timelines/1/timeline_elements', [
        'name' => fake()->name(),
        'era_id' => 1,
        'entry' => '',
        'use_event_date' => true,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ]);

it('GETS all timeline elements')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_elements')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ],
        ],
    ]);

it('GETS a specific timeline element')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_elements/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ]);

it('UPDATES a valid timeline element')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->putJson('/api/1.0/campaigns/1/timelines/1/timeline_elements/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('DELETES a timeline element')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->delete('/api/1.0/campaigns/1/timelines/1/timeline_elements/1')
    ->assertStatus(204);

it('DELETES an invalid timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->delete('/api/1.0/campaigns/1/timelines/1/timeline_elements/100')
    ->assertStatus(404);

it('can GET a timeline as a player')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->withTimelineElements()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_elements/1')
    ->assertStatus(200);
