<?php

use App\Models\Campaign;

it('offsets the bottom anchor ad above mobile navigation on non-boosted campaigns', function () {
    config([
        'ads.provider' => 'nitro',
        'ads.nitro.enabled' => true,
        'ads.nitro.tags.siderail_right' => 'yes',
    ]);

    $this->withoutVite()->asUser()->withCampaign();
    $user = auth()->user();
    $user->forceFill(['created_at' => now()->subDays(2)])->saveQuietly();
    $campaign = Campaign::firstOrFail();

    $response = $this->get(route('dashboard', $campaign))
        ->assertSuccessful();

    $response->assertSee('ad-nitro-sticky')
        ->assertSee('has-mobile-navigation')
        ->assertSee('"anchorStickyOffset": stickyOffset', false)
        ->assertDontSee('"anchorStickyOffset": 0', false);
});

it('does not render the bottom anchor ad on boosted campaigns', function () {
    config([
        'ads.provider' => 'nitro',
        'ads.nitro.enabled' => true,
        'ads.nitro.tags.siderail_right' => 'yes',
    ]);

    $this->withoutVite()->asUser()->withCampaign(['boost_count' => 1]);
    $user = auth()->user();
    $user->forceFill(['created_at' => now()->subDays(2)])->saveQuietly();
    $campaign = Campaign::firstOrFail();

    $this->get(route('dashboard', $campaign))
        ->assertSuccessful()
        ->assertDontSee('ad-nitro-sticky');
});
