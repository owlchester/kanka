<?php

use App\Models\CommunityEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('setups up one', function() {
    $event = factory(CommunityEvent::class)->make();
    $event->save();
});


it('has a community events page')->get('/en/community-events')->assertStatus(200);
