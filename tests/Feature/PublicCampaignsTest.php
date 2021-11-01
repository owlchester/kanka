<?php


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('setups up one', function() {
    $models = factory(\App\Models\Campaign::class, 10)->create();
});

it('has a public campaigns page')->get('/en/public-campaigns')->assertStatus(200);
