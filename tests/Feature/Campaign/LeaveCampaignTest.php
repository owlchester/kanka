<?php

use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\User;

it('sends a left notification instead of role removal notifications when a user leaves a campaign', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    $member = User::factory()->create();
    CampaignUser::create([
        'campaign_id' => $campaign->id,
        'user_id' => $member->id,
    ]);
    CampaignRoleUser::create([
        'campaign_role_id' => $playerRole->id,
        'user_id' => $member->id,
    ]);

    // Clear the role-added notification created during setup
    $member->notifications()->delete();
    $owner->notifications()->delete();

    $this->actingAs($member)
        ->post(route('campaign.leave-process', $campaign))
        ->assertRedirect(route('home'));

    expect(CampaignUser::where('campaign_id', $campaign->id)->where('user_id', $member->id)->exists())->toBeFalse();
    expect(CampaignRoleUser::where('campaign_role_id', $playerRole->id)->where('user_id', $member->id)->exists())->toBeFalse();

    $memberNotifications = $member->notifications()->get();
    expect($memberNotifications)->toHaveCount(1);

    $notification = $memberNotifications->first();
    expect($notification->data['key'])->toBe('campaign.left');
    expect($notification->data['params']['campaign'])->toBe($campaign->name);
    expect(__('notifications.' . $notification->data['key'], $notification->data['params']))
        ->toBe("You have left {$campaign->name}.");

    expect($memberNotifications->where('data.key', 'campaign.role.remove'))->toBeEmpty();

    $ownerNotifications = $owner->notifications()->get();
    expect($ownerNotifications->pluck('data.key'))->toContain('campaign.leave');
});

it('still sends a role removal notification when a role is removed directly', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    $member = User::factory()->create();
    CampaignUser::create([
        'campaign_id' => $campaign->id,
        'user_id' => $member->id,
    ]);
    $roleUser = CampaignRoleUser::create([
        'campaign_role_id' => $playerRole->id,
        'user_id' => $member->id,
    ]);

    $member->notifications()->delete();

    $roleUser->delete();

    $memberNotifications = $member->notifications()->get();
    expect($memberNotifications)->toHaveCount(1);
    expect($memberNotifications->first()->data['key'])->toBe('campaign.role.remove');
});
