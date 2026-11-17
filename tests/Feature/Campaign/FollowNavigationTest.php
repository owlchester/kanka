<?php

use App\Enums\CampaignVisibility;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;

it('updates the shared navigation list immediately after following and unfollowing a world', function () {
    $this->asUser()->withCampaign();
    $world = Campaign::factory()->create([
        'name' => 'A followed world',
        'slug' => 'followed-world',
        'visibility_id' => CampaignVisibility::public->value,
    ]);
    CampaignSetting::create(['campaign_id' => $world->id]);
    CampaignRole::create(['campaign_id' => $world->id, 'name' => 'Owner', 'is_admin' => true]);
    $navigationUrl = route('layout.navigation');
    $followUrl = route('campaign.follow', $world);

    $this->getJson($navigationUrl)
        ->assertSuccessful()
        ->assertJsonCount(0, 'campaigns.following');

    $this->postJson($followUrl)
        ->assertSuccessful()
        ->assertJsonPath('following', true);

    $this->getJson($navigationUrl)
        ->assertSuccessful()
        ->assertJsonCount(1, 'campaigns.following')
        ->assertJsonPath('campaigns.following.0.name', $world->name)
        ->assertJsonPath('campaigns.following.0.url', route('dashboard', $world));

    $this->postJson($followUrl)
        ->assertSuccessful()
        ->assertJsonPath('following', false);

    $this->getJson($navigationUrl)
        ->assertSuccessful()
        ->assertJsonCount(0, 'campaigns.following');
});
