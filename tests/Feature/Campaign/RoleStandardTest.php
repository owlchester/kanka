<?php

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\EntityType;
use App\Models\User;

it('renders the modernized standard role UI without pretty-checkbox and hides the form for admin roles', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();
    $adminRole = $campaign->roles()->admin()->firstOrFail();

    $this->get(route('campaign_roles.show', [$campaign, $playerRole]))
        ->assertSuccessful()
        ->assertSee(__('campaigns/roles.standard.advanced.toggle'))
        ->assertSee(__('campaigns/roles.standard.presets.contribute'))
        ->assertSee(__('campaigns/roles.standard.features.groups.campaign'))
        ->assertSee(__('campaigns.roles.users.actions.add'))
        ->assertDontSee('pretty-checkbox');

    $this->get(route('campaign_roles.show', [$campaign, $adminRole]))
        ->assertSuccessful()
        ->assertDontSee(__('campaigns/roles.standard.advanced.toggle'))
        ->assertDontSee('pretty-checkbox');
});

it('saves category and campaign feature permissions while preserving entity-specific overrides', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();
    $character = EntityType::where('code', 'character')->firstOrFail();
    $location = EntityType::where('code', 'location')->firstOrFail();

    // Entity-specific override that should NOT be deleted when general permissions are saved.
    $entityOverride = CampaignPermission::create([
        'campaign_role_id' => $playerRole->id,
        'access' => true,
        'action' => CampaignPermission::ACTION_EDIT,
        'entity_type_id' => $character->id,
        'entity_id' => 999,
    ]);

    $this->post(route('campaign_roles.savePermissions', [$campaign, 'campaign_role' => $playerRole]), [
        'permissions' => [
            "{$character->id}_" . CampaignPermission::ACTION_READ => (string) $character->id,
            "{$character->id}_" . CampaignPermission::ACTION_EDIT => (string) $character->id,
            'campaign_' . CampaignPermission::ACTION_DASHBOARD => 'campaign',
        ],
    ])->assertRedirect(route('campaign_roles.show', [$campaign, 'campaign_role' => $playerRole]));

    // Submitted category permissions exist.
    expect(
        $playerRole->permissions()
            ->where('entity_type_id', $character->id)
            ->where('action', CampaignPermission::ACTION_READ)
            ->whereNull('entity_id')
            ->exists()
    )->toBeTrue();

    expect(
        $playerRole->permissions()
            ->where('entity_type_id', $character->id)
            ->where('action', CampaignPermission::ACTION_EDIT)
            ->whereNull('entity_id')
            ->exists()
    )->toBeTrue();

    // Omitted general permission (e.g. location read seeded by withCampaign) was cleared.
    expect(
        $playerRole->permissions()
            ->where('entity_type_id', $location->id)
            ->where('action', CampaignPermission::ACTION_READ)
            ->whereNull('entity_id')
            ->exists()
    )->toBeFalse();

    // Submitted campaign feature permission exists.
    expect(
        $playerRole->permissions()
            ->whereNull('entity_type_id')
            ->where('action', CampaignPermission::ACTION_DASHBOARD)
            ->exists()
    )->toBeTrue();

    // Entity-specific override was preserved.
    expect(CampaignPermission::find($entityOverride->id))->not->toBeNull();
});

it('forbids non-admin members from viewing or saving standard role permissions', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();

    $member = User::factory()->create();
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $member->id]);
    CampaignRoleUser::create(['campaign_role_id' => $playerRole->id, 'user_id' => $member->id]);

    $this->actingAs($member)
        ->get(route('campaign_roles.show', [$campaign, $playerRole]))
        ->assertForbidden();

    $this->actingAs($member)
        ->post(route('campaign_roles.savePermissions', [$campaign, 'campaign_role' => $playerRole]), [
            'permissions' => [],
        ])
        ->assertForbidden();
});
