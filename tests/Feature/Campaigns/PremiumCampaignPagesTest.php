<?php

it('shows the sidebar premium alert with feature tracking', function () {
    $this->asUser()
        ->withCampaign()
        ->get(route('campaign-sidebar', 1))
        ->assertOk()
        ->assertSee(__('campaigns/sidebar.cta.title'))
        ->assertSee(e(route('settings.subscription', ['f' => 'cta', 's' => 'sidebar', 'w' => 1])), false);
});

it('shows the placeholder empty state and upgrade action', function () {
    $this->asUser()
        ->withCampaign()
        ->get(route('campaign.default-images', 1))
        ->assertOk()
        ->assertSee(__('campaigns/default-images.empty.title'))
        ->assertSee(__('campaigns/default-images.empty.description'))
        ->assertSee(e(route('settings.subscription', ['f' => 'cta', 's' => 'placeholder-images', 'w' => 1])), false);
});

it('shows the webhook premium alert without a create action for non-premium campaigns', function () {
    $createUrl = route('webhooks.create', 'test-campaign');

    $this->asUser()
        ->withCampaign()
        ->get(route('webhooks.index', 1))
        ->assertOk()
        ->assertSee(__('campaigns/webhooks.cta.title'))
        ->assertSee(__('campaigns/webhooks.empty.title'))
        ->assertDontSee('data-url="' . $createUrl . '"', false);
});

it('shows the webhook create action for premium campaigns', function () {
    $createUrl = route('webhooks.create', 'test-campaign', false);

    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->get(route('webhooks.index', 1))
        ->assertOk()
        ->assertDontSee(__('campaigns/webhooks.cta.title'))
        ->assertSee($createUrl, false);
});

it('shows the plugin empty state and marketplace action', function () {
    if (! config('marketplace.enabled')) {
        $this->markTestSkipped('The marketplace routes are disabled.');
    }

    $this->asUser()
        ->withCampaign()
        ->get(route('campaign_plugins.index', 1))
        ->assertOk()
        ->assertSee(__('campaigns/plugins.cta.title'))
        ->assertSee(__('campaigns/plugins.empty.title'))
        ->assertSee(config('marketplace.url'), false);
});

it('shows the achievements premium alert until the campaign is superboosted', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 1])
        ->get(route('campaign.achievements', 1))
        ->assertOk()
        ->assertSee(__('campaigns/achievements.cta.title'))
        ->assertSee(e(route('settings.subscription', ['f' => 'cta', 's' => 'achievements', 'w' => 1])), false);
});

it('exposes recovery empty-state translations', function () {
    $this->asUser()
        ->withCampaign()
        ->get(route('recovery.setup', 1))
        ->assertOk()
        ->assertJsonPath('elements', [])
        ->assertJsonPath('i18n.empty_title', __('campaigns/recovery.empty_title'))
        ->assertJsonPath('i18n.empty', __('campaigns/recovery.empty'));
});
