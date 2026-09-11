<?php

use App\Models\CampaignUser;
use App\Models\User;

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

test('sorts campaign members by shared last login and puts private logins last', function () {
    $this->asUser()->withCampaign();

    $old = User::factory()->create([
        'name' => 'Shared old',
        'last_login_at' => '2026-01-01 00:00:00',
        'has_last_login_sharing' => true,
    ]);
    $new = User::factory()->create([
        'name' => 'Shared new',
        'last_login_at' => '2026-02-01 00:00:00',
        'has_last_login_sharing' => true,
    ]);
    $private = User::factory()->create([
        'name' => 'Private login',
        'last_login_at' => '2026-03-01 00:00:00',
        'has_last_login_sharing' => false,
    ]);

    foreach ([$old, $new, $private] as $user) {
        CampaignUser::create(['campaign_id' => 1, 'user_id' => $user->id]);
    }

    $members = CampaignUser::whereIn('user_id', [$old->id, $new->id, $private->id])
        ->sort(['k' => 'last_login', 'o' => 'asc'])
        ->with('user')
        ->get();

    expect($members->pluck('user.name')->all())->toBe([
        'Shared old',
        'Shared new',
        'Private login',
    ]);

    $members = CampaignUser::whereIn('user_id', [$old->id, $new->id, $private->id])
        ->sort(['k' => 'last_login', 'o' => 'desc'])
        ->with('user')
        ->get();

    expect($members->pluck('user.name')->all())->toBe([
        'Shared new',
        'Shared old',
        'Private login',
    ]);
});
