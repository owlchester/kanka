<?php

it('POSTS a new permission test')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->asPlayer()
    ->postJson('/api/1.0/campaigns/1/permissions/test', [
        [
            'user_id' => 2,
            'entity_type_id' => 1,
            'action' => 1,
        ],
    ])
    ->assertStatus(200);

it('POSTS a new permission')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withMember()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_permissions', [
        [
            'campaign_role_id' => 2,
            'access' => 1,
            'action' => 1,
        ],
    ])
    ->assertJsonStructure([
        'data' => [
            [
                'access',
            ],
        ],
    ])
    ->assertStatus(200);

it('DELETES a permission')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withPermissions()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_permissions/1')
    ->assertStatus(204);
