<?php

it('POSTS an invalid user role form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/users', [])
    ->assertStatus(422);

it('POSTS a new user role')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->postJson('/api/1.0/campaigns/1/users', [
        'user_id' => 2,
        'role_id' => 1,
    ])
    ->assertJsonFragment([
        'role successfully added to user',
    ])
    ->assertStatus(200);

it('GETS all campaign members')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->get('/api/1.0/campaigns/1/users')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ],
        ],
    ]);

it('GETS a specific campaign member')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->get('/api/1.0/campaigns/1/users/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ],
        ],
    ]);

it('DELETES a user role')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->delete('/api/1.0/campaigns/1/users', [
        'user_id' => 2,
        'role_id' => 3,
    ])
    ->assertJsonFragment([
        'role successfully removed from the user',
    ])
    ->assertStatus(200);

it('DELETES an invalid user role')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->delete('/api/1.0/campaigns/1/users')
    ->assertStatus(422);

it('GETS all campaign roles')
    ->asUser()
    ->withCampaign()
    ->withMember()
    ->get('/api/1.0/campaigns/1/roles')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
            ],
        ],
    ]);
