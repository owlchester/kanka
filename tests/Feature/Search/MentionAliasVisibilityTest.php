<?php

use App\Enums\CampaignVisibility;
use App\Enums\EntityAssetType;
use App\Enums\Visibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

beforeEach(function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public]);
    $this->campaign = Campaign::findOrFail(1);
    $this->entity = Character::factory()->create(['campaign_id' => $this->campaign->id, 'name' => 'Public name'])->entity;

    // Ranking uses MariaDB-only FIELD/RLIKE; exercise visibility on SQLite without ranking.
    Entity::addGlobalScope('search-test-ordering', fn (Builder $query) => $query->reorder());
});

afterEach(function () {
    $scopes = Entity::getAllGlobalScopes();
    unset($scopes[Entity::class]['search-test-ordering']);
    Entity::setAllGlobalScopes($scopes);
});

it('matches only aliases visible to the viewer', function (string $viewer, Visibility $visibility, bool $visible, string $route) {
    $alias = EntityAsset::factory()->create([
        'entity_id' => $this->entity->id,
        'type_id' => EntityAssetType::alias,
        'name' => 'Secret identity',
        'visibility_id' => $visibility,
    ]);

    if ($viewer === 'player' || $viewer === 'creator') {
        $this->asPlayer();
    }

    if ($viewer === 'creator') {
        $alias->created_by = auth()->id();
        $alias->saveQuietly();
    } elseif ($viewer === 'admin' && $visibility === Visibility::Self) {
        $alias->created_by = User::factory()->create()->id;
        $alias->saveQuietly();
    }

    // VisibilityIDScope intentionally skips console requests; exercise its web behaviour.
    $console = new ReflectionProperty(app(), 'isRunningInConsole');
    $console->setValue(app(), false);

    try {
        foreach (['Secret', '=Secret identity'] as $term) {
            $response = $this->getJson(route($route, ['campaign' => $this->campaign, 'q' => $term]))
                ->assertSuccessful();
            $results = $route === 'search.mention' ? $response->json('entities') : $response->json();

            expect(collect($results)->pluck('alias_id')->contains($alias->id))->toBe($visible);
            if (! $visible) {
                expect($results)->toBeEmpty();
            }
        }

        if (! $visible) {
            $alias->updateQuietly(['name' => 'Public name Secret identity']);
            $response = $this->getJson(route($route, ['campaign' => $this->campaign, 'q' => 'Public name']))
                ->assertSuccessful();
            $results = $route === 'search.mention' ? $response->json('entities') : $response->json();

            expect(collect($results)->pluck('id'))->toContain($this->entity->id);
            $response->assertDontSee('Secret identity');
        }
    } finally {
        $console->setValue(app(), true);
    }
})->with([
    'player public alias' => ['player', Visibility::All, true],
    'player members alias' => ['player', Visibility::Member, true],
    'player admin alias' => ['player', Visibility::Admin, false],
    'player other admin-self alias' => ['player', Visibility::AdminSelf, false],
    'player other self alias' => ['player', Visibility::Self, false],
    'creator admin-self alias' => ['creator', Visibility::AdminSelf, true],
    'creator self alias' => ['creator', Visibility::Self, true],
    'admin admin alias' => ['admin', Visibility::Admin, true],
    'admin admin-self alias' => ['admin', Visibility::AdminSelf, true],
    'admin other self alias' => ['admin', Visibility::Self, false],
])->with(['search.mention', 'search.live']);

it('only matches public aliases for guests or nonmembers', function (Visibility $visibility, bool $visible, string $viewer) {
    $this->withoutMiddleware(ReplicationSwitcher::class);
    $alias = EntityAsset::factory()->create([
        'entity_id' => $this->entity->id,
        'type_id' => EntityAssetType::alias,
        'name' => 'Alias identity',
        'visibility_id' => $visibility,
    ]);

    if ($viewer === 'guest') {
        auth()->forgetGuards();
    } else {
        $this->actingAs(User::factory()->create());
    }

    $console = new ReflectionProperty(app(), 'isRunningInConsole');
    $console->setValue(app(), false);
    try {
        $response = $this->getJson(route('search.live', ['campaign' => $this->campaign, 'q' => 'Alias identity']))
            ->assertSuccessful();

        expect(collect($response->json())->pluck('alias_id')->contains($alias->id))->toBe($visible);
        if (! $visible) {
            $response->assertExactJson([]);
        }
    } finally {
        $console->setValue(app(), true);
    }
})->with([
    'public alias' => [Visibility::All, true],
    'members alias' => [Visibility::Member, false],
    'admin alias' => [Visibility::Admin, false],
    'admin-self alias' => [Visibility::AdminSelf, false],
    'self alias' => [Visibility::Self, false],
])->with(['guest', 'nonmember']);
