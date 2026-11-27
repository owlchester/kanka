<?php

use App\Exceptions\TranslatableException;
use App\Http\Requests\API\UpdateUserRole;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\User;
use App\Services\Campaign\MemberService;

it('hides the remove button and forbids removing the last admin from the admin role', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    // Give the sole admin another role so needs_more_roles wouldn't be the blocker.
    CampaignRoleUser::create([
        'campaign_role_id' => $playerRole->id,
        'user_id' => $owner->id,
    ]);

    $adminRoleUser = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $this->get(route('campaign_roles.show', [$campaign, $adminRole]))
        ->assertSuccessful()
        ->assertDontSee(urlencode(route('campaign_roles.campaign_role_users.destroy', [$campaign, $adminRole, $adminRoleUser])));

    $this->delete(route('campaign_roles.campaign_role_users.destroy', [$campaign, $adminRole, $adminRoleUser]))
        ->assertForbidden();

    expect(CampaignRoleUser::find($adminRoleUser->id))->not->toBeNull();
});

it('forbids bypassing the admin check by passing a non-admin role in the destroy route', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    $adminRoleUser = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $this->delete(route('campaign_roles.campaign_role_users.destroy', [$campaign, $playerRole, $adminRoleUser]))
        ->assertForbidden();

    expect(CampaignRoleUser::find($adminRoleUser->id))->not->toBeNull();
});

it('allows an admin with another role to remove themselves when another admin exists', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    $secondAdmin = User::factory()->create();
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $secondAdmin->id]);
    CampaignRoleUser::create(['campaign_role_id' => $adminRole->id, 'user_id' => $secondAdmin->id]);

    CampaignRoleUser::create([
        'campaign_role_id' => $playerRole->id,
        'user_id' => $owner->id,
    ]);

    $ownerAdminRoleUser = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $this->get(route('campaign_roles.show', [$campaign, $adminRole]))
        ->assertSuccessful()
        ->assertSee(urlencode(route('campaign_roles.campaign_role_users.destroy', [$campaign, $adminRole, $ownerAdminRoleUser])));

    $this->delete(route('campaign_roles.campaign_role_users.destroy', [$campaign, $adminRole, $ownerAdminRoleUser]))
        ->assertRedirect(route('campaign_roles.show', [$campaign, $adminRole]))
        ->assertSessionHas('success');

    expect(CampaignRoleUser::find($ownerAdminRoleUser->id))->toBeNull();
});

it('still requires another role when an admin removes themselves while another admin exists', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();

    $secondAdmin = User::factory()->create();
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $secondAdmin->id]);
    CampaignRoleUser::create(['campaign_role_id' => $adminRole->id, 'user_id' => $secondAdmin->id]);

    $ownerAdminRoleUser = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $this->delete(route('campaign_roles.campaign_role_users.destroy', [$campaign, $adminRole, $ownerAdminRoleUser]))
        ->assertRedirect(route('campaign_roles.show', [$campaign, $adminRole]))
        ->assertSessionHas('error_raw');

    expect(CampaignRoleUser::find($ownerAdminRoleUser->id))->not->toBeNull();
});

it('blocks removing the last admin in MemberService delete, update, and remove', function () {
    $this->asUser()->withCampaign();

    $owner = auth()->user();
    $campaign = Campaign::firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    CampaignRoleUser::create([
        'campaign_role_id' => $playerRole->id,
        'user_id' => $owner->id,
    ]);

    $adminRoleUser = CampaignRoleUser::where('campaign_role_id', $adminRole->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $campaignUser = CampaignUser::where('campaign_id', $campaign->id)
        ->where('user_id', $owner->id)
        ->firstOrFail();

    $service = app(MemberService::class);

    expect(fn () => $service->user($owner)->element($adminRoleUser)->delete())
        ->toThrow(TranslatableException::class);

    expect(fn () => $service->campaign($campaign)->user($owner)->update($campaignUser, [$playerRole->id]))
        ->toThrow(TranslatableException::class);

    $request = UpdateUserRole::create('/', 'DELETE', [
        'user_id' => $owner->id,
        'role_id' => $adminRole->id,
    ]);

    expect($service->fromRequest($request)->campaign($campaign)->remove())->toBeFalse();
    expect(CampaignRoleUser::find($adminRoleUser->id))->not->toBeNull();
});
