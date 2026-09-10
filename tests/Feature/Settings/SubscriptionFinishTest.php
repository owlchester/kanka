<?php

use App\Enums\CampaignVisibility;
use App\Http\Controllers\Settings\SubscriptionController;
use App\Models\Campaign;
use App\Models\CampaignBoost;

it('automatically enables premium for a users only campaign', function () {
    config(['services.stripe.enabled' => true]);

    $this->asUser(subscribed: true)->withCampaign();
    auth()->user()->forceFill(['booster_count' => 10])->save();
    session()->put(SubscriptionController::SUCCESS_SESSION_KEY, true);

    $this->get(route('settings.subscription.finish'))
        ->assertOk()
        ->assertSee('Premium features enabled');

    expect(CampaignBoost::query()->count())->toBe(4)
        ->and(CampaignBoost::query()->where('automatically_assigned', true)->count())->toBe(4);
});

it('enables premium for the campaign selected before subscribing', function () {
    config(['services.stripe.enabled' => true]);

    $this->asUser(subscribed: true)->withCampaign()->withCampaigns();
    auth()->user()->forceFill(['booster_count' => 10])->save();
    session()->put([
        SubscriptionController::SUCCESS_SESSION_KEY => true,
        SubscriptionController::CAMPAIGN_SESSION_KEY => 2,
    ]);

    $this->get(route('settings.subscription.finish'))
        ->assertOk()
        ->assertSee('Premium features enabled');

    expect(CampaignBoost::query()->where('campaign_id', 1)->count())->toBe(0)
        ->and(CampaignBoost::query()->where('campaign_id', 2)->count())->toBe(4)
        ->and(CampaignBoost::query()->where('campaign_id', 2)->where('automatically_assigned', true)->count())->toBe(4);
});

it('enables premium for a selected public campaign', function () {
    config(['services.stripe.enabled' => true]);

    $this->asUser(subscribed: true)->withCampaign();
    auth()->user()->forceFill(['booster_count' => 10])->save();
    $campaign = Campaign::factory()->create([
        'slug' => 'public-campaign',
        'visibility_id' => CampaignVisibility::public,
    ]);
    session()->put([
        SubscriptionController::SUCCESS_SESSION_KEY => true,
        SubscriptionController::CAMPAIGN_SESSION_KEY => $campaign->id,
    ]);

    $this->get(route('settings.subscription.finish'))
        ->assertOk()
        ->assertSee('Premium features enabled');

    expect(CampaignBoost::query()->where('campaign_id', $campaign->id)->count())->toBe(4);
});

it('does not automatically select a campaign when the user has multiple campaigns', function () {
    config(['services.stripe.enabled' => true]);

    $this->asUser(subscribed: true)->withCampaign()->withCampaigns();
    auth()->user()->forceFill(['booster_count' => 10])->save();
    session()->put(SubscriptionController::SUCCESS_SESSION_KEY, true);

    $this->get(route('settings.subscription.finish'))
        ->assertOk()
        ->assertSee('Enable premium features on a campaign');

    expect(CampaignBoost::query()->count())->toBe(0);
});

it('only processes the subscription success session once', function () {
    config(['services.stripe.enabled' => true]);

    $this->asUser(subscribed: true)->withCampaign();
    auth()->user()->forceFill(['booster_count' => 10])->save();
    session()->put(SubscriptionController::SUCCESS_SESSION_KEY, true);

    $this->get(route('settings.subscription.finish'))->assertOk();
    $this->get(route('settings.subscription.finish'))
        ->assertOk()
        ->assertSee('Enable premium features on a campaign');

    expect(CampaignBoost::query()->count())->toBe(4);
});
