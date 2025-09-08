<?php

it('POSTS an invalid timeline era form')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->postJson('/api/1.0/campaigns/1/timelines/1/timeline_eras', [])
    ->assertStatus(422);

it('POSTS a new timeline era')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->postJson('/api/1.0/campaigns/1/timelines/1/timeline_eras', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ]);

it('GETS all timeline eras')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_eras')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ],
        ],
    ]);

it('GETS a specific timeline era')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_eras/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ]);

it('UPDATES a valid timeline era')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->putJson('/api/1.0/campaigns/1/timelines/1/timeline_eras/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('UPDATES a valid timeline era without a name')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->putJson('/api/1.0/campaigns/1/timelines/1/timeline_eras/1', ['entry' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['entry' => '<p>Magic</p>']);

it('DELETES a timeline era')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->delete('/api/1.0/campaigns/1/timelines/1/timeline_eras/1')
    ->assertStatus(204);

it('DELETES an invalid timeline')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->delete('/api/1.0/campaigns/1/timelines/1/timeline_eras/100')
    ->assertStatus(404);

it('can GET a timeline as a player')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->withTimelineEras()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/timelines/1/timeline_eras/1')
    ->assertStatus(200);
