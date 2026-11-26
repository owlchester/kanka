<?php

use App\Models\Campaign;
use App\Models\CampaignBoost;
use Illuminate\Support\Facades\DB;

it('renders settings premium when boosted and unboosted campaigns have a null slug', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withCampaigns(['boost_count' => 0]);

    $boostedCampaign = Campaign::query()->findOrFail(1);
    $unboostedCampaign = Campaign::query()->findOrFail(2);

    DB::table('campaigns')
        ->whereIn('id', [$boostedCampaign->id, $unboostedCampaign->id])
        ->update(['slug' => null]);

    CampaignBoost::create([
        'campaign_id' => $boostedCampaign->id,
        'user_id' => auth()->id(),
    ]);

    $this->get(route('settings.premium'))
        ->assertSuccessful()
        ->assertSee(route('dashboard', $boostedCampaign->id), false)
        ->assertSee(route('dashboard', $unboostedCampaign->id), false);
});

it('correctly detects vanity slugs when slug is null, numeric id, or custom', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::query()->findOrFail(1);
    DB::table('campaigns')->where('id', $campaign->id)->update(['slug' => null]);
    $campaign->refresh();
    expect($campaign->hasVanity())->toBeFalse();

    $campaign->slug = (string) $campaign->id;
    expect($campaign->hasVanity())->toBeFalse();

    $campaign->slug = 'custom-vanity-slug';
    expect($campaign->hasVanity())->toBeTrue();
});

it('opens the campaign boost dialog when the campaign has a null slug', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::query()->findOrFail(1);
    DB::table('campaigns')->where('id', $campaign->id)->update(['slug' => null]);
    $campaign->refresh();

    $this->get(route('campaign_boosts.create', ['campaign' => $campaign]))
        ->assertSuccessful();
});

it('does not blank out campaign slug when updating with an empty slug parameter', function () {
    $this->asUser()->withCampaign(['slug' => 'my-vanity-world']);

    $campaign = Campaign::query()->findOrFail(1);

    $this->patch(route('campaigns.update', $campaign), [
        'name' => $campaign->name,
        'slug' => '',
        'ui_settings' => [],
    ])->assertRedirect();

    expect($campaign->fresh()->slug)->toBe('my-vanity-world');
});

it('automatically populates slug when creating a campaign directly', function () {
    $campaign = Campaign::create(['name' => 'Direct Campaign']);

    expect($campaign->slug)->toBe((string) $campaign->id)
        ->and($campaign->fresh()->slug)->toBe((string) $campaign->id);
});

it('restores slug to id when saving an existing campaign with a null slug', function () {
    $this->asUser()->withCampaign(['slug' => 'initial-slug']);

    $campaign = Campaign::query()->findOrFail(1);
    $campaign->slug = null;
    $campaign->save();

    expect($campaign->fresh()->slug)->toBe((string) $campaign->id);
});
