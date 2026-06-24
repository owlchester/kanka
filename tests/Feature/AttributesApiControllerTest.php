<?php

use App\Models\User;

it('authenticated user can load entity attributes api', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign()->withCharacters();

    $this->getJson('/w/test-campaign/attributes/api/entity/1')
        ->assertOk();
});

it('authenticated user can load type attributes api', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->withCampaign();

    $this->getJson('/w/test-campaign/attributes/api/type/1')
        ->assertOk();
});
