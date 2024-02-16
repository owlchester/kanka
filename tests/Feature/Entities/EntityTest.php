<?php

it('GETS all entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities')
    ->assertStatus(200)
;

it('GETS a specific entity')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities/1')
    ->assertStatus(200)
;

it('GETS all creatures')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities?types=creature')
    ->assertStatus(200)
    ->assertJsonCount(5, 'data');
;

it('Transforms entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transform', [
        'entities' => [1,2,3],
        'entity_type' => 'organisation'
    ])
    ->assertJsonFragment(['success' => 'Succesfully transformed 3 entities.'])
    ->assertStatus(200)
;

it('POSTS a new character with a mention and checks that a new entity is created')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
        'entry' => '[new:item|Mega sword]',
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ]
    ])
    ->assertJsonFragment(['entry_parsed' => '<a href="' . env('APP_URL') .
        '/w/1/entities/1" class="entity-mention" data-entity-tags="" data-entity-type="item" data-toggle="tooltip-ajax" data-id="1" data-url="' . 
        env('APP_URL') . '/w/1/entities/1/tooltip">Mega sword</a>'])
;

it('Transfers entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1,2,3],
        'campaign_id' => 2,
    ])
    ->assertJsonFragment(['success' => 'Succesfully transfered 3 entities.'])
    ->assertStatus(200)
;

it('Copies entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1,2,3],
        'campaign_id' => 2,
        'copy'  => true
    ])
    ->assertJsonFragment(['success' => 'Succesfully copied 3 entities.'])
    ->assertStatus(200)
;
