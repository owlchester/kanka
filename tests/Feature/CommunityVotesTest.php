<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('setups up one', function() {
    $event = factory(\App\Models\CommunityEvent::class)->create();
});

it('has a community votes page')->get('/en/community-votes')->assertStatus(200);
