<?php

use App\Enums\CampaignVisibility;
use App\Enums\Permission;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\User;
use App\Services\Submenus\SubmenuService;

it('omits permissions from the entity submenu', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;
    $user = User::findOrFail(1);

    $items = app(SubmenuService::class)
        ->campaign($campaign)
        ->user($user)
        ->entity($entity)
        ->items();

    $keys = collect($items)->flatMap(fn ($section) => array_keys($section))->all();

    expect($keys)->not->toContain('permissions');
});

it('loads the unified share sheet for admins with only overridden members marked', function () {
    $this->asUser()->withCampaign()->withCharacters()->withMember();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;
    $member = User::findOrFail(2);
    $otherMember = User::factory()->create();
    $campaign->users()->attach($otherMember->id);

    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'user_id' => $member->id,
        'entity_type_id' => $entity->type_id,
        'entity_id' => $entity->id,
        'action' => Permission::View->value,
        'access' => true,
    ]);

    $response = $this->get(route('entities.permissions', [$campaign, $entity]))
        ->assertOk()
        ->assertViewHas('canTogglePrivacy', true)
        ->assertViewHas('canEditPermissions', true);

    $catalog = collect($response->viewData('membersCatalog'));
    expect($catalog->firstWhere('id', $member->id)['has_override'])->toBeTrue()
        ->and($catalog->firstWhere('id', $otherMember->id)['has_override'])->toBeFalse();
});

it('allows a non-admin with entity permissions to open and save the share sheet without privacy toggle', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;

    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'campaign_role_id' => 3,
        'entity_type_id' => $entity->type_id,
        'action' => Permission::Update->value,
        'access' => true,
    ]);
    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'campaign_role_id' => 3,
        'entity_type_id' => $entity->type_id,
        'entity_id' => $entity->id,
        'action' => Permission::Permissions->value,
        'access' => true,
    ]);

    $this->asPlayer();

    $this->get(route('entities.permissions', [$campaign, $entity]))
        ->assertOk()
        ->assertViewHas('canTogglePrivacy', false)
        ->assertViewHas('canEditPermissions', true);

    $this->post(route('entities.permissions-process', [$campaign, $entity]), [
        'entity_id' => $entity->id,
        'role' => [
            3 => [
                Permission::View->value => 'allow',
                Permission::Update->value => 'inherit',
                Permission::Delete->value => 'inherit',
                Permission::Posts->value => 'inherit',
            ],
        ],
    ])->assertRedirect();

    expect(CampaignPermission::where('entity_id', $entity->id)
        ->where('campaign_role_id', 3)
        ->where('action', Permission::View->value)
        ->where('access', true)
        ->exists())->toBeTrue();
});

it('persists member overrides and deletes removed member overrides on save', function () {
    $this->asUser()->withCampaign()->withCharacters()->withMember();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;
    $member = User::findOrFail(2);

    $this->post(route('entities.permissions-process', [$campaign, $entity]), [
        'entity_id' => $entity->id,
        'user' => [
            $member->id => [
                Permission::View->value => 'allow',
                Permission::Update->value => 'inherit',
                Permission::Delete->value => 'inherit',
                Permission::Posts->value => 'inherit',
            ],
        ],
    ])->assertRedirect();

    expect(CampaignPermission::where('entity_id', $entity->id)
        ->where('user_id', $member->id)
        ->where('action', Permission::View->value)
        ->where('access', true)
        ->exists())->toBeTrue();

    // Simulate a fresh request so the cached Route controller & PermissionService are reset
    app('router')->getRoutes()->getByName('entities.permissions-process')->flushController();

    // Removing member from submitted payload deletes their override
    $this->post(route('entities.permissions-process', [$campaign, $entity]), [
        'entity_id' => $entity->id,
    ])->assertRedirect()->assertSessionHas('success_raw');

    expect(CampaignPermission::where('entity_id', $entity->id)
        ->where('user_id', $member->id)
        ->exists())->toBeFalse();
});

it('forbids unauthorized players from accessing the share sheet', function () {
    $this->asUser()->withCampaign()->withCharacters()->asPlayer();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;

    $this->get(route('entities.permissions', [$campaign, $entity]))
        ->assertForbidden();
});

it('forbids guests from accessing the share sheet on public campaigns', function () {
    $this->withoutMiddleware(ReplicationSwitcher::class);
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public])->withCharacters();

    $campaign = Campaign::findOrFail(1);
    $entity = Character::findOrFail(1)->entity;

    auth()->forgetGuards();
    $this->app['auth']->guard('web')->logout();

    $this->get(route('entities.permissions', [$campaign, $entity]))
        ->assertForbidden();

    $this->get(route('entities.quick-privacy', [$campaign, $entity]))
        ->assertForbidden();
});
