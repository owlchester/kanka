<?php

use App\Models\EntityType;

it('guides users without premium access to subscription plans when editing a module', function () {
    $this->asUser()
        ->withCampaign(['name' => 'Test Campaign'])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertSee(__('callouts.premium.multiple', ['campaign' => '<strong>Test Campaign</strong>']), false)
        ->assertSee(e(route('settings.subscription', ['f' => 'cta', 'w' => 1])), false)
        ->assertSee('disabled="disabled"', false);
});

it('guides users with premium access to enable it when editing a module', function () {
    $this->asUser(true)
        ->withCampaign(['name' => 'Test Campaign'])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertSee(e(route('settings.premium', ['campaign' => 'test-campaign'])), false)
        ->assertSee(__('settings/premium.actions.unlock'))
        ->assertSee('disabled="disabled"', false)
        ->assertDontSee(e(route('settings.subscription', ['f' => 'cta', 'w' => 1])), false);
});

it('does not show premium guidance for a premium campaign', function () {
    $this->asUser()
        ->withCampaign(['name' => 'Test Campaign', 'boost_count' => 4])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertDontSee(__('callouts.premium.multiple', ['campaign' => '<strong>Test Campaign</strong>']), false)
        ->assertDontSee('disabled="disabled"', false);
});
