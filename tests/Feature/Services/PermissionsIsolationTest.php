<?php

use App\Enums\Permission;
use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\User;
use App\Services\Permissions\EntityPermission;
use App\Traits\UserAware;

it('allows calling hasUser after userless without throwing an uninitialized property error', function () {
    $service = new class
    {
        use UserAware;
    };

    $user = User::factory()->create();

    expect($service->hasUser())->toBeFalse()
        ->and($service->user($user)->hasUser())->toBeTrue()
        ->and($service->userless()->hasUser())->toBeFalse();
});

it('isolates EntityPermission cache across different users on the same campaign', function () {
    $this->asUser()->withCampaign();
    $admin = auth()->user();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();
    $player = auth()->user();

    $permissions = app(EntityPermission::class);

    // Admin can update, player cannot, guest cannot — without calling resetPermissions() between calls
    expect($permissions->canEntity($character->entity, Permission::Update, $admin, $campaign))->toBeTrue()
        ->and($permissions->canEntity($character->entity, Permission::Update, $player, $campaign))->toBeFalse()
        ->and($permissions->canEntity($character->entity, Permission::Update, null, $campaign))->toBeFalse()
        ->and($permissions->canEntity($character->entity, Permission::View, $player, $campaign))->toBeTrue();
});

it('does not leak entityType from canEntityType into a subsequent canEntity check', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $locationType = EntityType::findOrFail(config('entities.ids.location'));

    // Give player role update permission on Locations, but NOT on Characters
    CampaignPermission::create([
        'campaign_role_id' => 3,
        'access' => true,
        'action' => CampaignPermission::ACTION_EDIT,
        'entity_type_id' => $locationType->id,
    ]);

    $this->asPlayer();
    $player = auth()->user();
    $permissions = app(EntityPermission::class);

    // Checking Locations first must not leak $locationType into the subsequent Character check
    expect($permissions->canEntityType($locationType, Permission::Update, $player, $campaign))->toBeTrue()
        ->and($permissions->canEntity($character->entity, Permission::Update, $player, $campaign))->toBeFalse();
});

it('resolves entity campaign automatically without global CampaignLocalization priming', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);

    $this->asPlayer();
    $player = auth()->user();

    CampaignLocalization::clearCampaign();

    // Must evaluate player's actual role (false), not fall back to the testing admin bypass
    expect($player->can('update', $character->entity))->toBeFalse()
        ->and($player->can('view', $character->entity))->toBeTrue();
});

it('auto-resets PermissionService when switching users without manual reload or reset', function () {
    $this->asUser()->withCampaign();
    $admin = auth()->user();
    $campaign = Campaign::findOrFail(1);

    $this->asPlayer();
    $player = auth()->user();

    expect(Permissions::campaign($campaign)->user($admin)->action(Permission::View)->isAdmin())->toBeTrue()
        ->and(Permissions::campaign($campaign)->user($player)->action(Permission::View)->isAdmin())->toBeFalse()
        ->and(Permissions::campaign($campaign)->userless()->action(Permission::View)->isAdmin())->toBeFalse();
});
