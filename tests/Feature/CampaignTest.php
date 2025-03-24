<?php

it('campaigns POST invalid')
    ->asUser()
    ->postJson('/api/1.0/campaigns', [])
    ->assertStatus(422);

it('campaigns POST valid')
    ->asUser()
    ->postJson('/api/1.0/campaigns', [
        'name' => fake()->name(),
        'entry' => fake()->text(500),
        'excerpt' => fake()->text(100),
    ])
    ->assertStatus(201);

it('campaigns GET')
    ->asUser()
    ->withCampaign()
    ->get('/api/1.0/campaigns')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
                'boosted',
                'superboosted',
                'premium',
                'members',
            ],
        ],
    ]);

it('campaign GET')
    ->asUser()
    ->withCampaign()
    ->get('/api/1.0/campaigns/1')
    ->assertStatus(200)
    ->assertJson([
        'data' => [
            'id' => 1,
        ],
    ]);

it('campaign PATCH')
    ->asUser()
    ->withCampaign()
    ->patchJson('/api/1.0/campaigns/1', [
        'name' => 'New name',
    ])
    ->assertJson([
        'data' => [
            'id' => 1,
            'name' => 'New name',
        ],
    ]);
