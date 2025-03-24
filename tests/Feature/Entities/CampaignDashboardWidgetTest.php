<?php

it('POSTS an invalid widget form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/campaign_dashboard_widgets', [])
    ->assertStatus(422);

it('POSTS a new widget')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->postJson('/api/1.0/campaigns/1/campaign_dashboard_widgets', [
        'widget' => 'header',
    ])
    ->assertStatus(201);

it('GETS all dashboard widgets')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->get('/api/1.0/campaigns/1/campaign_dashboard_widgets')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'widget',
            ],
        ],
    ]);

it('GETS a specific dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->get('/api/1.0/campaigns/1/campaign_dashboard_widgets/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'widget',
        ],
    ]);

it('DELETES a dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->delete('/api/1.0/campaigns/1/campaign_dashboard_widgets/1')
    ->assertStatus(204);

it('DELETES an invalid user role')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->delete('/api/1.0/campaigns/1/campaign_dashboard_widgets/100')
    ->assertStatus(404);

it('UPDATES a valid dashboard widget')
    ->asUser()
    ->withCampaign()
    ->withDashboardWidgets()
    ->putJson('/api/1.0/campaigns/1/campaign_dashboard_widgets/1', ['position' => 2, 'widget' => 'header'])
    ->assertStatus(200)
    ->assertJsonFragment(['position' => 2]);
