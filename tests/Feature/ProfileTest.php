<?php

it('profile GET')
    ->asUser()
    ->get('/api/1.0/profile')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_subscriber',
            'rate_limit',
        ],
    ])
    ->assertJson(['data' => ['id' => 1]])
    ->assertJsonMissingPath('data.password');
