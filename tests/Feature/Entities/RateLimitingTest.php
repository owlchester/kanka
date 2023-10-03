<?php

it('Tests Rate Limit')
    ->asUser()
    ->withCampaign()
    ->call('GET', '/api/1.0/entity-types')
    ->assertHeader('x-ratelimit-limit', '30')
;

it('Tests Rate Limit of Subscriber')
    ->asUser(true)
    ->withCampaign()
    ->call('GET', '/api/1.0/entity-types')
    ->assertHeader('x-ratelimit-limit', '90')
;