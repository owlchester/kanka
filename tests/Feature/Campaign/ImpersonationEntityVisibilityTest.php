<?php

use App\Enums\CampaignVisibility;
use App\Enums\Permission;
use App\Facades\Identity;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Services\Permissions\EntityVisibilityExplanation;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    config(['app.debug' => false, 'app.skip_permissions' => false]);
    $this->withoutVite()->asUser()->withCampaign()->withMember();
    $this->owner = auth()->user();
    $this->campaign = Campaign::firstOrFail();
    $this->membership = CampaignUser::where('campaign_id', $this->campaign->id)
        ->where('user_id', '!=', $this->owner->id)->firstOrFail();
    $this->member = $this->membership->user;
    $this->member->update(['name' => 'Mira & Co']);
    $this->player = $this->member->campaignRoles()->where('campaign_id', $this->campaign->id)->firstOrFail();
    $this->entity = Character::factory()->create([
        'campaign_id' => $this->campaign->id,
        'name' => 'Unseen entity name',
        'is_private' => false,
    ])->entity;

    $this->viewGrant = fn (array $values) => CampaignPermission::create($values + [
        'action' => Permission::View->value,
        'access' => true,
        'entity_id' => $this->entity->id,
        'campaign_id' => $this->campaign->id,
        'entity_type_id' => $this->entity->type_id,
    ]);
    $this->impersonate = fn () => $this->actingAs($this->member, 'web')->withSession([
        Identity::getSessionKey() => $this->owner->id,
        Identity::getSessionCampaignKey() => $this->campaign->id,
    ]);
    $this->entityUrl = route('entities.show', [$this->campaign, $this->entity]);
});

it('explains a private entity after switching to the member from that entity', function () {
    $this->entity->updateQuietly(['is_private' => true]);
    ($this->viewGrant)(['user_id' => $this->member->id]);
    $this->actingAs($this->owner, 'web')
        ->get(route('identity.switch-entity', [$this->campaign, $this->membership, $this->entity]))
        ->assertRedirect($this->entityUrl)
        ->assertSessionHas(Identity::getSessionKey(), $this->owner->id);

    $this->assertAuthenticatedAs($this->member, 'web');
    $response = $this->get($this->entityUrl)->assertNotFound()
        ->assertSee('This entry is private.')
        ->assertSee('Why can’t Mira & Co see this entry?')
        ->assertSee('Role for Mira & Co')
        ->assertSee('Direct View setting for Mira & Co: Allow')
        ->assertDontSee('Unseen entity name');

    expect($response->headers->hasCacheControlDirective('private'))->toBeTrue()
        ->and($response->headers->hasCacheControlDirective('no-store'))->toBeTrue();
});

it('explains an entity role deny and compares only the relevant campaign settings', function () {
    ($this->viewGrant)(['campaign_role_id' => $this->player->id, 'access' => false]);
    $otherRole = $this->campaign->roles()->create(['name' => '<b>Lorekeeper</b>']);
    ($this->viewGrant)(['campaign_role_id' => $otherRole->id]);
    CampaignRoleUser::create(['campaign_role_id' => $otherRole->id, 'user_id' => $this->member->id]);
    $empty = $this->campaign->roles()->create(['name' => 'Assigned without grants']);
    CampaignRoleUser::create(['campaign_role_id' => $empty->id, 'user_id' => $this->member->id]);
    $unassigned = $this->campaign->roles()->create(['name' => 'Unassigned module reader']);
    ($this->viewGrant)(['campaign_role_id' => $unassigned->id, 'campaign_id' => null, 'entity_id' => null]);
    $unrelated = $this->campaign->roles()->create(['name' => 'Unrelated role']);
    ($this->viewGrant)(['campaign_role_id' => $unrelated->id, 'action' => Permission::Update->value]);
    ($this->viewGrant)(['campaign_role_id' => $unrelated->id, 'entity_id' => null, 'entity_type_id' => config('entities.ids.location')]);

    ($this->impersonate)();
    $this->get(route('entities.show-slug', [$this->campaign, $this->entity, 'anything']))
        ->assertNotFound()
        ->assertSee('The following roles deny View on this entry:')
        ->assertSeeInOrder(['Player', 'Assigned', 'Granted', 'Deny'])
        ->assertSee('View on Characters')
        ->assertSee('View on this entry')
        ->assertSee('Assigned without grants')
        ->assertSee('Unassigned module reader')
        ->assertSee('&lt;b&gt;Lorekeeper&lt;/b&gt;', false)
        ->assertDontSee('<b>Lorekeeper</b>', false)
        ->assertDontSee('Unrelated role');
});

it('explains a direct deny when the parent fails to bind on a subpage', function () {
    $this->campaign->updateQuietly(['settings' => ['modules' => [$this->entity->type_id => ['p' => 'People']]]]);
    ($this->viewGrant)(['user_id' => $this->member->id, 'access' => false]);
    ($this->impersonate)();

    $this->get(route('entities.children', [$this->campaign, $this->entity]))
        ->assertNotFound()
        ->assertSee('View is explicitly denied for Mira & Co')
        ->assertSee('View on People')
        ->assertSee('Direct View setting for Mira & Co: Deny');
});

it('does not diagnose an assigned role deny cleared by a direct grant', function () {
    ($this->viewGrant)(['campaign_role_id' => $this->player->id, 'access' => false]);
    ($this->viewGrant)(['user_id' => $this->member->id]);
    ($this->impersonate)();

    $this->get($this->entityUrl)->assertSuccessful()->assertDontSee('entity-visibility-title', false);
});

it('explains a missing grant when the member has no roles and the public fallback does not grant View', function () {
    $this->player->users()->where('user_id', $this->member->id)->delete();
    $public = $this->campaign->roles()->where('is_public', true)->firstOrFail();
    $public->permissions()->where('entity_type_id', $this->entity->type_id)->delete();
    ($this->impersonate)();

    $this->get($this->entityUrl)->assertNotFound()
        ->assertSee('Mira & Co has no applicable View grant')
        ->assertSee('Applied by default')
        ->assertSee('Direct View setting for Mira & Co: Inherit');
});

it('identifies a public fallback deny even when there is a direct allow', function () {
    $this->player->users()->where('user_id', $this->member->id)->delete();
    $public = $this->campaign->roles()->where('is_public', true)->firstOrFail();
    ($this->viewGrant)(['campaign_role_id' => $public->id, 'access' => false]);
    ($this->viewGrant)(['user_id' => $this->member->id]);
    ($this->impersonate)();

    $this->get($this->entityUrl)->assertNotFound()
        ->assertSee('The following roles deny View on this entry:')
        ->assertSee('Applied by default')
        ->assertSee('Direct View setting for Mira & Co: Allow');
});

it('does not reveal existence outside an active authorised impersonation', function (string $state) {
    $this->entity->updateQuietly(['is_private' => true]);
    match ($state) {
        'member' => $this->actingAs($this->member, 'web'),
        'admin' => $this->actingAs($this->owner, 'web'),
        'guest' => auth()->forgetGuards(),
        default => ($this->impersonate)(),
    };
    if ($state === 'guest') {
        $this->campaign->updateQuietly(['visibility_id' => CampaignVisibility::public]);
    } elseif ($state === 'wrong-campaign') {
        $this->withSession([Identity::getSessionCampaignKey() => $this->campaign->id + 1]);
    } elseif ($state === 'removed-member') {
        $this->membership->delete();
    } elseif ($state === 'revoked-admin') {
        $this->campaign->roles()->where('is_admin', true)->update(['is_admin' => false]);
    }

    $response = $this->get($state === 'admin' ? $this->entityUrl . '123' : $this->entityUrl);
    if ($state === 'wrong-campaign') {
        $response->assertOk()->assertViewIs('errors.private-campaign');
    } else {
        $response->assertNotFound();
    }
    $response->assertDontSee('entity-visibility-title', false);
})->with(['guest', 'member', 'admin', 'wrong-campaign', 'removed-member', 'revoked-admin']);

it('does not explain deleted, nonexistent, foreign or unrelated targets', function (string $target) {
    Route::middleware('web')->get('/w/{campaign}/missing/{entity}', fn () => abort(404));
    $id = $this->entity->id;
    if ($target === 'deleted') {
        $this->entity->deleteQuietly();
    } elseif ($target === 'foreign') {
        $foreign = Campaign::factory()->create();
        $this->entity->updateQuietly(['campaign_id' => $foreign->id, 'is_private' => true]);
    } elseif ($target === 'nonexistent') {
        $id += 100;
    } elseif ($target === 'abort') {
        $this->entity->updateQuietly(['is_private' => true]);
    }
    ($this->impersonate)();
    $url = match ($target) {
        'missing-child' => route('entities.posts.logs', [$this->campaign, $this->entity, 999]),
        'abort' => '/w/' . $this->campaign->getRouteKey() . '/missing/' . $id,
        'unmatched' => '/w/' . $this->campaign->getRouteKey() . '/not-a-real-route',
        default => route('entities.show', [$this->campaign, $id]),
    };

    $this->get($url)->assertNotFound()->assertDontSee('entity-visibility-title', false);
})->with(['deleted', 'nonexistent', 'foreign', 'missing-child', 'unmatched', 'abort']);

it('does not include the HTML diagnosis in JSON, Ajax, API or permission errors', function () {
    ($this->impersonate)();
    $this->get(route('entities.permissions', [$this->campaign, $this->entity]))
        ->assertForbidden()->assertDontSee('entity-visibility-title', false);
    $this->entity->updateQuietly(['is_private' => true]);

    $this->getJson($this->entityUrl)->assertNotFound()->assertDontSee('entity-visibility-title', false);
    $this->get($this->entityUrl, ['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'text/html'])
        ->assertNotFound()->assertDontSee('entity-visibility-title', false);
    $this->getJson('/api/1.0/campaigns/' . $this->campaign->id . '/entities/' . ($this->entity->id + 100))
        ->assertNotFound()->assertDontSee('entity-visibility-title', false);
});

it('keeps the ordinary 404 when diagnosis fails', function () {
    $this->entity->updateQuietly(['is_private' => true]);
    ($this->impersonate)();
    Exceptions::fake();
    $failure = new RuntimeException('Diagnostic data unavailable');
    $this->mock(EntityVisibilityExplanation::class)->shouldReceive('forMissingBinding')
        ->once()->andThrow($failure);

    $this->get($this->entityUrl)->assertNotFound()->assertDontSee('entity-visibility-title', false);
    Exceptions::assertReported(fn (RuntimeException $exception) => $exception === $failure);
});
