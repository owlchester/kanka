<?php

use App\Enums\CampaignVisibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\EntityType;
use App\Models\User;
use App\Services\Campaign\CreateService;
use App\Services\Campaign\Sidebar\LayoutService;
use App\Services\EntityTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->asUser()->withCampaign([
        'boost_count' => 4,
        'ui_settings' => ['sidebar_v2' => ['enabled' => true]],
    ]);
    $this->campaign = Campaign::firstOrFail();
});

function sidebarV2Payload(Campaign $campaign, array $overrides = []): array
{
    $service = app(LayoutService::class)->campaign($campaign->fresh());

    return $overrides + [
        'action' => 'save',
        'target' => 'default',
        'revision' => $service->revision(),
        'items' => $service->standard()['items'],
    ];
}

it('renders the new editor and category navigation', function () {
    $this->get(route('campaign-sidebar', $this->campaign))
        ->assertOk()
        ->assertSee('id="sidebar-v2-editor"', false);
    $this->get(route('dashboard', $this->campaign))->assertOk()
        ->assertSee('data-sidebar-item="category:1"', false);
});

it('saves mixed top level items and sections without changing legacy settings', function () {
    $ui = $this->campaign->ui_settings;
    $ui['sidebar'] = ['labels' => ['characters' => 'Old heroes']];
    $ui['connections'] = 1;
    $this->campaign->update(['ui_settings' => $ui]);
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1, 'parent' => 'world', 'position' => 7]);
    $payload = sidebarV2Payload($this->campaign);
    $payload['items'] = [
        ['id' => 'system:settings'],
        ['id' => 'party', 'label' => 'The Party', 'children' => [['id' => 'category:1'], ['id' => 'bookmark:' . $bookmark->id]]],
        ['id' => 'bookmarks', 'label' => 'Bookmarks', 'children' => []],
        ['id' => 'system:dashboard'],
        ['id' => 'system:gallery'],
        ['id' => 'system:relations'],
        ['id' => 'system:history'],
    ];

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();

    $settings = $this->campaign->fresh()->ui_settings;
    expect($settings['sidebar_v2']['layouts']['default']['items'])->toBe($payload['items'])
        ->and($settings['sidebar']['labels']['characters'])->toBe('Old heroes')
        ->and($settings['connections'])->toBe(1)
        ->and($bookmark->fresh()->parent)->toBe('world')
        ->and($bookmark->fresh()->position)->toBe(7);
    $this->get(route('campaign-sidebar', $this->campaign))
        ->assertOk()->assertSee('The Party')->assertDontSee('Old heroes');
});

it('rejects invalid structures and protected item removal', function (string $invalid) {
    $payload = sidebarV2Payload($this->campaign);
    if ($invalid === 'duplicate') {
        $payload['items'][] = ['id' => 'category:1'];
    } elseif ($invalid === 'unknown') {
        $payload['items'][] = ['id' => 'bookmark:99999'];
    } elseif ($invalid === 'section-collision') {
        $payload['items'][] = ['id' => 'world', 'label' => 'Duplicate', 'children' => []];
    } elseif ($invalid === 'nested') {
        $payload['items'][1]['children'][] = ['id' => 'nested', 'children' => []];
    } elseif ($invalid === 'bookmarks') {
        array_splice($payload['items'], 1, 1);
    } else {
        array_shift($payload['items']);
    }

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertUnprocessable();
    expect($this->campaign->fresh()->ui_settings['sidebar_v2'])->not->toHaveKey('layouts');
})->with(['duplicate', 'unknown', 'section-collision', 'nested', 'bookmarks', 'protected']);

it('rejects a role or category from another campaign', function (string $foreign) {
    $other = Campaign::factory()->create();
    $payload = sidebarV2Payload($this->campaign);
    if ($foreign === 'role') {
        $role = CampaignRole::create(['campaign_id' => $other->id, 'name' => 'Foreign']);
        $payload['target'] = (string) $role->id;
    } else {
        $type = EntityType::forceCreate(['campaign_id' => $other->id, 'code' => 'foreign', 'plural' => 'Foreign', 'is_special' => true, 'is_enabled' => true, 'icon' => 'fa-solid fa-book']);
        $payload['items'][] = ['id' => 'category:' . $type->id];
    }

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertUnprocessable();
})->with(['role', 'category']);

it('rejects concurrent edits without losing the first save', function () {
    $payload = sidebarV2Payload($this->campaign);
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)
        ->assertUnprocessable()->assertJsonValidationErrors('revision');
});

it('requires campaign update permission and premium to save', function (string $restriction) {
    $payload = sidebarV2Payload($this->campaign);
    if ($restriction === 'premium') {
        DB::table('campaigns')->where('id', 1)->update(['boost_count' => 0]);
    } else {
        $this->asPlayer();
    }

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertForbidden();
})->with(['premium', 'permission']);

it('selects the first assigned role with a layout and honours reordered tag fields', function () {
    $role = CampaignRole::create(['campaign_id' => 1, 'name' => 'Second group']);
    $service = app(LayoutService::class)->campaign($this->campaign);
    foreach ([3, $role->id] as $id) {
        $payload = sidebarV2Payload($this->campaign, ['target' => (string) $id]);
        $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();
    }
    $this->asPlayer();
    $member = CampaignUser::where('user_id', auth()->id())->firstOrFail();
    CampaignRoleUser::create(['campaign_role_id' => $role->id, 'user_id' => auth()->id(), 'position' => 1]);
    expect($service->campaign($this->campaign->fresh())->target(auth()->user()))->toBe('3');

    $player = auth()->user();
    $this->actingAs(User::findOrFail(1));
    $this->post(route('campaign_users.update-roles', [$this->campaign, $member]), ['roles' => [$role->id, 3]])->assertRedirect();

    expect($service->campaign($this->campaign->fresh())->target($player))->toBe((string) $role->id)
        ->and($member->fresh()->roles->pluck('id')->all())->toBe([$role->id, 3]);
});

it('falls back to default when no assigned roles have an override and uses the guest override', function () {
    $service = app(LayoutService::class)->campaign($this->campaign);
    expect($service->target(null))->toBe('default')
        ->and($service->target(auth()->user()))->toBe('default');
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign, ['target' => '2']))->assertRedirect();
    expect($service->campaign($this->campaign->fresh())->target(null))->toBe('2')
        ->and($service->target(auth()->user()))->toBe('default');
});

it('appends new categories and bookmarks to every layout without restoring removed placements', function () {
    $payload = sidebarV2Payload($this->campaign);
    $payload['items'][2]['children'] = [];
    foreach (['default', '3'] as $target) {
        $payload['target'] = $target;
        $payload['revision'] = app(LayoutService::class)->campaign($this->campaign->fresh())->revision();
        $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();
    }
    $type = EntityType::forceCreate(['campaign_id' => 1, 'code' => 'kingdom', 'singular' => 'Kingdom', 'plural' => 'Kingdoms', 'is_special' => true, 'is_enabled' => true, 'icon' => 'fa-solid fa-crown']);
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1]);

    foreach (['default', '3'] as $target) {
        $layout = app(LayoutService::class)->campaign($this->campaign->fresh())->layout($target);
        expect($layout['items'][1]['children'])->toBe([
            ['id' => 'category:' . $type->id], ['id' => 'bookmark:' . $bookmark->id],
        ])->and($layout['items'][2]['children'])->toBeEmpty();
    }
});

it('starts clean while retaining legacy configuration and can roll back and resume', function () {
    $legacy = ['labels' => ['characters' => 'Legacy heroes']];
    $this->campaign->update(['ui_settings' => ['sidebar' => $legacy]]);
    $this->get(route('campaign-sidebar', $this->campaign))->assertSee('Legacy heroes');
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign, ['action' => 'start']))->assertRedirect();
    expect($this->campaign->fresh()->ui_settings['sidebar'])->toBe($legacy);
    $this->get(route('campaign-sidebar', $this->campaign))->assertSee('id="sidebar-v2-editor"', false)->assertDontSee('Legacy heroes');
    $this->withoutMiddleware(VerifyCsrfToken::class);
    $this->app->instance('env', 'local');
    foreach (['legacy' => false, 'resume' => true] as $action => $enabled) {
        $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign, ['action' => $action]))->assertRedirect();
        expect($this->campaign->fresh()->ui_settings['sidebar_v2']['enabled'])->toBe($enabled)
            ->and($this->campaign->fresh()->ui_settings['sidebar_v2']['layouts'])->toHaveKey('default');
    }
});

it('resets a role override to the campaign default without changing other layouts', function () {
    foreach (['default', '3'] as $target) {
        $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign, ['target' => $target]))->assertRedirect();
    }
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign, ['target' => '3', 'action' => 'reset']))->assertRedirect();
    expect($this->campaign->fresh()->ui_settings['sidebar_v2']['layouts'])->toHaveKey('default')->not->toHaveKey('3');
});

it('renders the standard v2 sidebar on premium loss without destroying saved layouts', function (bool $legacy) {
    $ui = ['sidebar' => ['labels' => ['characters' => 'Legacy heroes']], 'sidebar_v2' => ['enabled' => ! $legacy]];
    $this->campaign->update(['ui_settings' => $ui]);
    DB::table('campaigns')->where('id', 1)->update(['boost_count' => 0]);

    $service = app(LayoutService::class)->campaign($this->campaign->fresh());
    expect($service->usesV2())->toBeTrue();
    $this->get(route('dashboard', $this->campaign))->assertOk()
        ->assertSee('data-sidebar-item="category:1"', false)->assertDontSee('Legacy heroes');
    expect($this->campaign->fresh()->ui_settings)->toBe($ui);
})->with([true, false]);

it('hides private bookmarks and empty sections for players', function () {
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1, 'is_active' => true, 'is_private' => true, 'name' => 'Hidden plans']);
    $payload = sidebarV2Payload($this->campaign);
    $payload['items'][1]['children'] = [];
    $payload['items'][] = ['id' => 'secret', 'label' => 'Secret GM section', 'children' => [['id' => 'bookmark:' . $bookmark->id]]];
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();
    $this->asPlayer();

    $this->get(route('dashboard', $this->campaign))->assertOk()->assertDontSee('Secret GM section')->assertDontSee('Hidden plans');
});

it('enables v2 for newly created campaigns', function () {
    $campaign = app(CreateService::class)
        ->user(auth()->user())->data(['name' => 'New world', 'locale' => 'en'])->create();

    expect($campaign->ui_settings['sidebar_v2']['enabled'])->toBeTrue();
});

it('creates custom categories without synthetic bookmarks in v2 but preserves legacy creation', function (bool $legacy) {
    if ($legacy) {
        $this->campaign->update(['ui_settings' => []]);
    }
    $request = new Request([
        'singular' => 'Kingdom', 'plural' => 'Kingdoms', 'is_enabled' => true, 'icon' => 'fa-solid fa-crown',
    ]);
    $type = app(EntityTypeService::class)->campaign($this->campaign)->user(auth()->user())->request($request)->save();

    expect(Bookmark::where('entity_type_id', $type->id)->count())->toBe($legacy ? 1 : 0);
    if (! $legacy) {
        $this->get(route('dashboard', $this->campaign))->assertOk()->assertSee('data-sidebar-item="category:' . $type->id . '"', false);
    }
})->with([true, false]);

it('renders random bookmarks targeting any category', function () {
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'random_entity_type' => 'any', 'is_active' => true, 'name' => 'Surprise me']);

    $this->get(route('dashboard', $this->campaign))->assertOk()
        ->assertSee('Surprise me')->assertSee(route('bookmarks.random', [$this->campaign, $bookmark->id]), false);
});

it('does not expose categories or bookmark targets denied to the viewer', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    Bookmark::factory()->create(['campaign_id' => 1, 'entity_id' => $character->entity->id, 'is_active' => true, 'name' => 'Denied character bookmark']);
    CampaignPermission::where('campaign_role_id', 3)->where('entity_type_id', 1)->where('action', CampaignPermission::ACTION_READ)->delete();
    $this->asPlayer();

    $this->get(route('dashboard', $this->campaign))->assertOk()
        ->assertDontSee('data-sidebar-item="category:1"', false)->assertDontSee('Denied character bookmark');
});

it('rejects edits made before a new bookmark was created so new items cannot disappear', function () {
    $payload = sidebarV2Payload($this->campaign);
    Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1]);

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)
        ->assertUnprocessable()->assertJsonValidationErrors('revision');
});

it('ignores deleted sources in saved layouts', function () {
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1, 'name' => 'Deleted bookmark']);
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), sidebarV2Payload($this->campaign))->assertRedirect();
    $bookmark->delete();

    $this->get(route('dashboard', $this->campaign))->assertOk()->assertDontSee('Deleted bookmark');
});

it('renders the guest role layout for public visitors', function () {
    $this->withoutMiddleware(ReplicationSwitcher::class);
    $this->campaign->update(['visibility_id' => CampaignVisibility::public]);
    $payload = sidebarV2Payload($this->campaign, ['target' => '2']);
    $payload['items'][2]['label'] = 'Explore our world';
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();
    auth()->forgetGuards();
    $this->app['auth']->guard('web')->logout();

    $this->get(route('dashboard', $this->campaign))->assertOk()->assertSee('Explore our world');
});

it('does not alter role layouts when the campaign default changes', function () {
    $rolePayload = sidebarV2Payload($this->campaign, ['target' => '3']);
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $rolePayload)->assertRedirect();
    $defaultPayload = sidebarV2Payload($this->campaign);
    $defaultPayload['items'][2]['label'] = 'Default changed';
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $defaultPayload)->assertRedirect();

    $service = app(LayoutService::class)->campaign($this->campaign->fresh());
    expect($service->layout('3')['items'])->toBe($rolePayload['items'])
        ->and($service->layout()['items'][2]['label'])->toBe('Default changed');
});

it('rejects invalid role editor targets', function (mixed $target) {
    $this->get(route('campaign-sidebar', [$this->campaign, 'role' => $target]))->assertNotFound();
})->with(['unknown' => '99999', 'array' => [['3']], 'invalid' => 'bad']);

it('restricts the complete sidebar editor to admins even when a player can manage campaign details', function () {
    CampaignPermission::create([
        'campaign_role_id' => 3, 'entity_type_id' => null,
        'action' => CampaignPermission::ACTION_MANAGE, 'access' => true,
    ]);
    $payload = sidebarV2Payload($this->campaign);
    $this->asPlayer();
    expect(auth()->user()->can('update', $this->campaign))->toBeTrue();

    $this->get(route('campaign-sidebar', $this->campaign))->assertForbidden();
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertForbidden();
});

it('does not save during the maintenance preflight before a sidebar action is submitted', function (string $action) {
    if ($action === 'legacy') {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->app->instance('env', 'local');
    }
    $ui = $this->campaign->ui_settings;
    $ui['sidebar_v2']['enabled'] = $action !== 'start' && $action !== 'resume';
    $ui['sidebar_v2']['layouts']['default'] = app(LayoutService::class)->campaign($this->campaign)->standard();
    $this->campaign->update(['ui_settings' => $ui]);
    $data = [
        'action' => $action, 'target' => 'default',
        'revision' => app(LayoutService::class)->campaign($this->campaign->fresh())->revision(),
    ];
    $url = route('campaign-sidebar-v2-save', $this->campaign);

    $this->post($url, $data, ['X-Requested-With' => 'XMLHttpRequest'])->assertOk();
    expect($this->campaign->fresh()->ui_settings)->toBe($ui);

    $this->post($url, $data)->assertRedirect()->assertSessionHasNoErrors();
    $settings = $this->campaign->fresh()->ui_settings['sidebar_v2'];
    expect($settings['enabled'])->toBe($action !== 'legacy');
    if ($action === 'reset') {
        expect($settings['layouts'])->not->toHaveKey('default');
    }
})->with(['start', 'reset', 'legacy', 'resume']);

it('saves JSON layout changes even when they use the XMLHttpRequest header', function () {
    $payload = sidebarV2Payload($this->campaign);

    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload, ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertRedirect();

    expect($this->campaign->fresh()->ui_settings['sidebar_v2']['layouts']['default']['items'])->toBe($payload['items']);
});

it('renders sections as settings-style headings with aligned category and bookmark rows', function () {
    $bookmark = Bookmark::factory()->create(['campaign_id' => 1, 'entity_type_id' => 1, 'is_active' => true]);
    $payload = sidebarV2Payload($this->campaign);
    $payload['items'][1]['children'] = [];
    $payload['items'][2]['children'] = [];
    array_unshift($payload['items'], [
        'id' => 'party', 'label' => 'The Party',
        'children' => [['id' => 'category:1'], ['id' => 'bookmark:' . $bookmark->id]],
    ]);
    $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload)->assertRedirect();

    $response = $this->get(route('dashboard', $this->campaign))->assertOk();
    $document = new DOMDocument;
    @$document->loadHTML($response->getContent());
    $xpath = new DOMXPath($document);
    $section = '//li[@data-section="party"]';

    expect($xpath->query($section . '/div[contains(@class, "uppercase") and contains(@class, "px-4")]')->length)->toBe(1)
        ->and($xpath->query($section . '/div//i')->length)->toBe(0)
        ->and($xpath->query('//li[@data-section="bookmarks"]/a[contains(@class, "px-4") and contains(@class, "py-1.5")]')->length)->toBe(1)
        ->and($xpath->query('//li[@data-section="bookmarks"]/div/a')->length)->toBe(0)
        ->and($xpath->query($section . '/ul[contains(@class, "pl-3")]')->length)->toBe(0)
        ->and($xpath->query($section . '/ul/li[contains(@class, "px-2")]')->length)->toBe(2);
});

it('only offers and accepts legacy rollback in local development', function (string $environment) {
    $this->withoutMiddleware(VerifyCsrfToken::class);
    $payload = sidebarV2Payload($this->campaign, ['action' => 'legacy']);
    $original = $this->campaign->ui_settings;
    $this->app->instance('env', $environment);

    $page = $this->get(route('campaign-sidebar', $this->campaign))->assertOk();
    $response = $this->postJson(route('campaign-sidebar-v2-save', $this->campaign), $payload);

    if ($environment === 'local') {
        $page->assertSee(__('campaigns/sidebar-v2.legacy'));
        $response->assertRedirect();
        expect($this->campaign->fresh()->ui_settings['sidebar_v2']['enabled'])->toBeFalse();
    } else {
        $page->assertDontSee(__('campaigns/sidebar-v2.legacy'));
        $response->assertUnprocessable()->assertJsonValidationErrors('action');
        expect($this->campaign->fresh()->ui_settings)->toBe($original);
    }
})->with(['local', 'production', 'staging']);

it('explains and styles the reset action separately from discarding unsaved edits', function (string $target) {
    $this->get(route('campaign-sidebar', [$this->campaign, 'role' => $target]))
        ->assertOk()
        ->assertSee('class="btn2 btn-outline"', false)
        ->assertSee(__('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default' : 'reset_role')))
        ->assertSee(__('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default_help' : 'reset_role_help')));
})->with(['default', '3']);
