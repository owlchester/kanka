<?php

use App\Models\TimelineEra;

it('displays an era with only a negative end year', function () {
    $era = new TimelineEra(['end_year' => -500]);

    expect($era->ages())->toBe('< -500');
});

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
        'start_year' => -500,
        'end_year' => 1200,
        'is_collapsed' => true,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
        ],
    ])
    ->assertJsonPath('data.start_year', -500)
    ->assertJsonPath('data.end_year', 1200)
    ->assertJsonPath('data.is_collapsed', true);

it('validates timeline era years and collapsed state')
    ->asUser()
    ->withCampaign()
    ->withTimelines()
    ->postJson('/api/1.0/campaigns/1/timelines/1/timeline_eras', [
        'name' => fake()->name(),
        'start_year' => 'invalid',
        'end_year' => 'invalid',
        'is_collapsed' => 'invalid',
    ])
    ->assertUnprocessable()
    ->assertJsonStructure([
        'fields' => [
            'start_year',
            'end_year',
            'is_collapsed',
        ],
    ]);

it('returns element display fields in a timeline era', function () {
    $this->asUser()
        ->withCampaign()
        ->withTimelines()
        ->withTimelineEras()
        ->withTimelineElements([
            'date' => '3rd of Appen 114',
            'icon' => 'fa-solid fa-star',
            'use_entity_entry' => true,
            'use_event_date' => true,
        ]);

    $this->getJson('/api/1.0/campaigns/1/timelines/1/timeline_eras/1')
        ->assertSuccessful()
        ->assertJsonPath('data.elements.0.date', '3rd of Appen 114')
        ->assertJsonPath('data.elements.0.icon', 'fa-solid fa-star')
        ->assertJsonPath('data.elements.0.use_entity_entry', true)
        ->assertJsonPath('data.elements.0.use_event_date', true);
});

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
