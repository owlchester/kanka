<?php

it('Tests rate limit of non subscriber')
    ->asUser()
    ->withCampaign()
    ->call('GET', '/api/1.0/entity-types')
    ->assertHeader('x-ratelimit-limit', '30');

it('Tests rate limit of subscriber')
    ->asUser(true)
    ->withCampaign()
    ->call('GET', '/api/1.0/entity-types')
    ->assertHeader('x-ratelimit-limit', '90');
