<?php

use App\Models\Organisation;

it('POSTS an invalid organisation form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/organisations', [])
    ->assertStatus(422);

it('POSTS a new organisation')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/organisations', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all organisations')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->get('/api/1.0/campaigns/1/organisations')
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

it('GETS a specific organisation')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->get('/api/1.0/campaigns/1/organisations/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid organisation')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->putJson('/api/1.0/campaigns/1/organisations/1', ['name' => 'Republic of Dave'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Republic of Dave']);

it('UPDATES a valid organisation without a name')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->putJson('/api/1.0/campaigns/1/organisations/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a organisation')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->delete('/api/1.0/campaigns/1/organisations/1')
    ->assertStatus(204);

it('DELETES an invalid organisation')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->delete('/api/1.0/campaigns/1/organisations/100')
    ->assertStatus(404);

it('can GET a organisation as a player')
    ->asUser()
    ->withCampaign()
    ->withOrganisations()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/organisations/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private organisation as a player', function () {
    $this->asUser()
        ->withCampaign();

    Organisation::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/organisations/1');
    expect($response->status())
        ->toBe(404);
});
