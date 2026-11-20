<?php

use App\Enums\CampaignFlags;
use App\Enums\CampaignVisibility;
use App\Models\Campaign;
use App\Models\User;
use Laravel\Passport\Passport;

it('shows a copyright notice to campaign members on campaign pages', function () {
    $this->asUser()->withCampaign();

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->get(route('overview', 1))
        ->assertOk()
        ->assertSeeText('Please respond to our email.');
});

it('does not show a copyright notice to non-members', function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public]);

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    Passport::actingAs(User::factory()->create(), ['*']);

    $this->get(route('overview', 1))
        ->assertOk()
        ->assertDontSeeText('Please respond to our email.');
});

it('blocks changing campaign visibility while a copyright notice is active', function () {
    $this->asUser()->withCampaign();

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->post(route('campaign-visibility.save', 1), ['visibility_id' => 3])
        ->assertForbidden();

    expect(Campaign::find(1)->isPrivate())->toBeTrue();
});

it('does not permit making a flagged campaign public through the share endpoint', function () {
    $this->asUser()->withCampaign();

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->postJson(route('campaign.share.save', 1), ['campaign_visibility' => 'public'])
        ->assertForbidden();
});

it('rejects visibility changes in the standard campaign update endpoint while flagged', function () {
    $this->asUser()->withCampaign();

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->patch(route('campaigns.update', 1), ['visibility_id' => 3])
        ->assertForbidden();
});

it('does not change campaign visibility through the api while flagged', function () {
    $this->asUser()->withCampaign();

    Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->patchJson('/api/1.0/campaigns/1', [
        'name' => 'Updated campaign name',
        'visibility_id' => 3,
    ])
        ->assertSuccessful();

    expect(Campaign::find(1)->isPrivate())->toBeTrue();
});

it('allows visibility changes after the copyright flag is removed', function () {
    $this->asUser()->withCampaign();

    $flag = Campaign::find(1)->flags()->create([
        'flag' => CampaignFlags::Copyright,
        'value' => 'Please respond to our email.',
    ]);

    $this->post(route('campaign-visibility.save', 1), ['visibility_id' => 3])
        ->assertForbidden();

    $flag->delete();

    $this->post(route('campaign-visibility.save', 1), ['visibility_id' => 3])
        ->assertRedirect();

    expect(Campaign::find(1)->isPublic())->toBeTrue();
});
