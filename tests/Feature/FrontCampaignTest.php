<?php

it('setup GET')
    ->asUser()
    ->withCampaign(['visibility_id' => \App\Enums\CampaignVisibility::public->value, 'is_featured' => true])
    ->get('/api/public/campaigns-setup')
    ->assertStatus(200)
    ->assertJsonStructure([
        'filters' => [
            'language',
            'system[]',
            'is_boosted',
            'is_open',
            'genre',
        ],
        'featured' => [
            [
                'id',
                'name',
                'link',
                'thumb',
                'entities',
                'followers',
                'locale',
                'system',
            ],
        ],
    ]);

it('public campaigns GET')
    ->asUser()
    ->withCampaign(['visibility_id' => \App\Enums\CampaignVisibility::public])
    ->get('/api/public/campaigns')
    ->assertStatus(200)
    ->assertJsonStructure([
        'campaigns' => [
            [
                'id',
                'name',
                'link',
                'thumb',
                'entities',
                'followers',
                'locale',
                'system',
            ],
        ],
    ]);

it('filtering GET 0 results')
    ->asUser()
    ->withCampaign(['visibility_id' => \App\Enums\CampaignVisibility::public, 'is_featured' => true, 'boost_count' => 0])
    ->get('/api/public/campaigns?is_boosted=1')
    ->assertStatus(200)
    ->assertJsonCount(0, 'campaigns');

it('filtering premium GET')
    ->asUser()
    ->withCampaign(['visibility_id' => \App\Enums\CampaignVisibility::public, 'boost_count' => 3])
    ->get('/api/public/campaigns?is_boosted=1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'campaigns' => [
            [
                'id',
                'name',
                'link',
                'thumb',
                'entities',
                'followers',
                'locale',
                'system',
            ],
        ],
    ]);
it('filtering locale GET')
    ->asUser()
    ->withCampaign(['visibility_id' => \App\Enums\CampaignVisibility::public, 'boost_count' => 3, 'locale' => 'fr'])
    ->get('/api/public/campaigns?language=fr')
    ->assertStatus(200)
    ->assertJsonCount(1, 'campaigns');

it('public campaigns GET buut no results due to is_discreet')
    ->asUser()
    ->withCampaign(['is_discreet' => true])
    ->get('/api/public/campaigns')
    ->assertStatus(200)
    ->assertJsonCount(0, 'campaigns');
