<?php

use App\Models\CampaignBoost;
use App\Models\EntityType;
use App\Models\User;

it('guides users without premium access to subscription plans when editing a module', function () {
    $this->asUser()
        ->withCampaign(['name' => 'Test Campaign'])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertSee(__('campaigns/modules.rename.premium.title'))
        ->assertSee(__('campaigns/modules.rename.premium.description'))
        ->assertSee(e(route('settings.subscription', ['f' => 'cta', 'w' => 1])), false)
        ->assertSee('fa-regular fa-lock', false)
        ->assertSee('disabled="disabled"', false);
});

it('guides users with premium access to enable it when editing a module', function () {
    $this->asUser(true)
        ->withCampaign(['name' => 'Test Campaign'])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertSee(__('campaigns/modules.rename.premium.title'))
        ->assertSee(__('campaigns/modules.rename.premium.description'))
        ->assertSee(e(route('settings.premium', ['campaign' => 'test-campaign'])), false)
        ->assertSee(__('campaigns/modules.rename.premium.upgrade', ['campaign' => 'Test Campaign']))
        ->assertSee('disabled="disabled"', false)
        ->assertDontSee(e(route('settings.subscription', ['f' => 'cta', 'w' => 1])), false);
});

it('does not show premium guidance for a premium campaign', function () {
    $this->asUser()
        ->withCampaign(['name' => 'Test Campaign', 'boost_count' => 4])
        ->get(route('modules.edit', [1, EntityType::default()->first()]))
        ->assertOk()
        ->assertDontSee(__('campaigns/modules.rename.premium.title'))
        ->assertDontSee(__('campaigns/modules.rename.premium.description'))
        ->assertDontSee('fa-regular fa-lock', false)
        ->assertDontSee('disabled="disabled"', false);
});

it('shows subscription upgrade guidance to the user unlocking a premium campaign at the category limit', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4]);

    auth()->user()->update(['pledge' => 'Owlbear']);
    CampaignBoost::create([
        'campaign_id' => 1,
        'user_id' => auth()->id(),
    ]);

    foreach (range(1, config('limits.campaigns.modules.premium')) as $position) {
        $entityType = new EntityType;
        $entityType->campaign_id = 1;
        $entityType->code = 'custom-' . $position;
        $entityType->singular = 'Custom ' . $position;
        $entityType->plural = 'Custom ' . $position . 's';
        $entityType->icon = 'fa-tag';
        $entityType->is_special = true;
        $entityType->is_enabled = true;
        $entityType->save();
    }

    $this->get(route('entity_types.create', 1))
        ->assertOk()
        ->assertSee(__('campaigns/modules.errors.subscription-upgrade', [
            'wyvern' => config('limits.campaigns.modules.wyvern'),
            'elemental' => config('limits.campaigns.modules.elemental'),
        ]))
        ->assertSee(__('callouts.actions.subscription'))
        ->assertSee(e(route('settings.subscription')), false);
});

it('does not show subscription upgrade guidance to another campaign member at the category limit', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4]);

    $unlocker = User::factory()->create(['pledge' => 'Owlbear']);
    CampaignBoost::create([
        'campaign_id' => 1,
        'user_id' => $unlocker->id,
    ]);

    foreach (range(1, config('limits.campaigns.modules.premium')) as $position) {
        $entityType = new EntityType;
        $entityType->campaign_id = 1;
        $entityType->code = 'custom-' . $position;
        $entityType->singular = 'Custom ' . $position;
        $entityType->plural = 'Custom ' . $position . 's';
        $entityType->icon = 'fa-tag';
        $entityType->is_special = true;
        $entityType->is_enabled = true;
        $entityType->save();
    }

    $this->get(route('entity_types.create', 1))
        ->assertOk()
        ->assertSee(__('campaigns/modules.errors.subscription-limit'))
        ->assertDontSee(__('campaigns/modules.errors.subscription-upgrade'))
        ->assertDontSee(e(route('settings.subscription')), false);
});
