<?php

it('rejects no token')
    ->get('/api/1.0/profile')
    ->assertStatus(401);

it('rejects invalid token')
    ->get('/api/1.0/profile', ['Authorization' => 'Bearer: FAKE'])
    ->assertStatus(401);

it('approves a valid token')
    ->asUser()
    ->get('/api/1.0/profile')
    ->assertStatus(200);
