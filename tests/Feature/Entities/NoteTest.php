<?php

use App\Models\Note;

it('POSTS an invalid note form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/notes', [])
    ->assertStatus(422);

it('POSTS a new note')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/notes', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all notes')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->get('/api/1.0/campaigns/1/notes')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific note')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->get('/api/1.0/campaigns/1/notes/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid note')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->putJson('/api/1.0/campaigns/1/notes/1', ['name' => 'Shopping List'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Shopping List']);

it('UPDATES a valid note without a name')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->putJson('/api/1.0/campaigns/1/notes/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a note')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->delete('/api/1.0/campaigns/1/notes/1')
    ->assertStatus(204);

it('DELETES an invalid note')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->delete('/api/1.0/campaigns/1/notes/100')
    ->assertStatus(404);

it('can GET a note as a player')
    ->asUser()
    ->withCampaign()
    ->withNotes()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/notes/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private note as a player', function () {
    $this->asUser()
        ->withCampaign();

    Note::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/notes/1');
    expect($response->status())
        ->toBe(404);
});
