<?php

use App\Enums\CampaignVisibility;
use App\Enums\Permission;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\EntityType;
use App\Models\User;

it('renders the public role permissions UI with active cards, disabled section, summary, and private notice', function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::private->value]);

    $campaign = Campaign::firstOrFail();
    $publicRole = $campaign->roles()->public()->firstOrFail();

    $response = $this->get(route('campaign_roles.show', [$campaign, $publicRole]));

    $response->assertSuccessful()
        ->assertSee('role="switch"', false)
        ->assertSee('data-public-role-summary', false)
        ->assertSee('data-public-role-bulk="1"', false)
        ->assertSee('data-public-role-bulk="0"', false)
        ->assertSee(__('campaigns/roles.public.private_notice.title'))
        ->assertSee('Disabled categories (');
});

it('hides the private campaign notice when the campaign is public', function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public->value]);

    $campaign = Campaign::firstOrFail();
    $publicRole = $campaign->roles()->public()->firstOrFail();

    $this->get(route('campaign_roles.show', [$campaign, $publicRole]))
        ->assertSuccessful()
        ->assertDontSee(__('campaigns/roles.public.private_notice.title'));
});

it('allows an admin to toggle a single category on the public role and rejects invalid requests', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $publicRole = $campaign->roles()->public()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();
    $characters = EntityType::where('code', 'character')->firstOrFail();

    // Seeded as enabled; first toggle disables it.
    $this->postJson(route('campaign_roles.toggle', [$campaign, $publicRole, $characters, Permission::View->value]))
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'status' => false,
        ]);

    expect(
        $publicRole->permissions()
            ->where('entity_type_id', $characters->id)
            ->where('action', Permission::View->value)
            ->exists()
    )->toBeFalse();

    // Second toggle re-enables it.
    $this->postJson(route('campaign_roles.toggle', [$campaign, $publicRole, $characters, Permission::View->value]))
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'status' => true,
        ]);

    expect(
        $publicRole->permissions()
            ->where('entity_type_id', $characters->id)
            ->where('action', Permission::View->value)
            ->exists()
    )->toBeTrue();

    // Non-public role returns 404.
    $this->postJson(route('campaign_roles.toggle', [$campaign, $playerRole, $characters, Permission::View->value]))
        ->assertNotFound();

    // Non-admin member returns 403.
    $member = User::factory()->create();
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $member->id]);
    CampaignRoleUser::create(['campaign_role_id' => $playerRole->id, 'user_id' => $member->id]);

    $this->actingAs($member)
        ->postJson(route('campaign_roles.toggle', [$campaign, $publicRole, $characters, Permission::View->value]))
        ->assertForbidden();
});

it('bulk toggles public categories for active modules only when enabling and all modules when disabling', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $publicRole = $campaign->roles()->public()->firstOrFail();
    $playerRole = $campaign->roles()->where('is_admin', false)->where('is_public', false)->firstOrFail();
    $diceRoll = EntityType::where('code', 'dice_roll')->firstOrFail();
    $character = EntityType::where('code', 'character')->firstOrFail();

    // Disable all categories (including dice_roll which is a disabled campaign category).
    $this->postJson(route('campaign_roles.toggle-all', [$campaign, $publicRole]), ['enabled' => false])
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'enabled' => false,
        ]);

    expect(
        $publicRole->permissions()
            ->where('action', Permission::View->value)
            ->whereNull('entity_id')
            ->where('entity_type_id', '!=', config('entities.ids.bookmark'))
            ->count()
    )->toBe(0);

    // Enable all: should enable active categories (e.g. character) and NOT enable disabled categories (e.g. dice_roll).
    $this->postJson(route('campaign_roles.toggle-all', [$campaign, $publicRole]), ['enabled' => true])
        ->assertSuccessful()
        ->assertJson([
            'success' => true,
            'enabled' => true,
        ]);

    expect(
        $publicRole->permissions()
            ->where('entity_type_id', $character->id)
            ->where('action', Permission::View->value)
            ->exists()
    )->toBeTrue();

    expect(
        $publicRole->permissions()
            ->where('entity_type_id', $diceRoll->id)
            ->where('action', Permission::View->value)
            ->exists()
    )->toBeFalse();

    // Non-public role returns 404.
    $this->postJson(route('campaign_roles.toggle-all', [$campaign, $playerRole]), ['enabled' => true])
        ->assertNotFound();

    // Non-admin member returns 403.
    $member = User::factory()->create();
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $member->id]);
    CampaignRoleUser::create(['campaign_role_id' => $playerRole->id, 'user_id' => $member->id]);

    $this->actingAs($member)
        ->postJson(route('campaign_roles.toggle-all', [$campaign, $publicRole]), ['enabled' => false])
        ->assertForbidden();
});
