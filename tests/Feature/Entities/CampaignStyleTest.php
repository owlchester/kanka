<?php

it('POSTS a new campaign_style')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->postJson('/api/1.0/campaigns/1/campaign_styles', [
        'name' => fake()->name(),
        'content' => fake()->text(50),
        'is_enabled' => false,
        'is_theme' => false,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'campaign_id',
            'name',
        ],
    ]);

it('GETS all campaign_styles')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->get('/api/1.0/campaigns/1/campaign_styles')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'campaign_id',
                'name',
            ],
        ],
    ]);

it('GETS a specific campaign_style')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->get('/api/1.0/campaigns/1/campaign_styles/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'campaign_id',
            'name',
        ],
    ]);

it('UPDATES a valid campaign_style')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->putJson('/api/1.0/campaigns/1/campaign_styles/1', ['name' => 'bob', 'content' => 'content', 'is_enabled' => true])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'bob']);

it('DELETES a campaign_style')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->delete('/api/1.0/campaigns/1/campaign_styles/1')
    ->assertStatus(204);

it('DELETES an invalid campaign_style')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->delete('/api/1.0/campaigns/1/campaign_styles/100')
    ->assertStatus(404);

it('cant GET a campaign_style as a player')
    ->asUser(true)
    ->withCampaign(['boost_count' => 4])
    ->withCampaignStyles()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/campaign_styles/1')
    ->assertStatus(403);
