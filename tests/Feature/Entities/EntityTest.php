<?php

it('GETS all entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities')
    ->assertStatus(200);

it('GETS a specific entity')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities/1')
    ->assertStatus(200);

it('GETS all creatures')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities?types=creature')
    ->assertStatus(200)
    ->assertJsonCount(5, 'data');

it('Transforms entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transform', [
        'entities' => [1, 2, 3],
        'entity_type' => 'organisation',
    ])
    ->assertJsonFragment(['success' => 'Succesfully transformed 3 entities.'])
    ->assertStatus(200);

it('POSTS a new character with a mention and checks that a new entity is created', function () {
    $this->asUser()
        ->withCampaign();

    $response = $this->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
        'entry' => '[new:item|Mega sword]',
    ]);
    $this->assertStringStartsWith('<p><a href="', json_decode($response->content(), true)['data']['entry_parsed']);
});

it('Transfers entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1, 2, 3],
        'campaign_id' => 2,
    ])
    ->assertStatus(200)
    ->assertJsonFragment(['success' => 'Succesfully transfered 3 entities.']);

it('Copies entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1, 2, 3],
        'campaign_id' => 2,
        'copy' => true,
    ])
    ->assertStatus(200)
    ->assertJsonFragment(['success' => 'Succesfully copied 3 entities.']);
