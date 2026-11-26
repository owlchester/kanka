<?php

use App\Enums\FeatureStatus as FeatureStatusEnum;
use App\Jobs\SubscriptionEndJob;
use App\Livewire\Roadmap\Champion;
use App\Livewire\Roadmap\Ideas;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\FeatureChampion;
use App\Models\FeatureStatus;
use App\Models\Pledge;
use App\Models\Role;
use App\Models\User;
use App\Services\DiscordService;
use App\Services\Roadmap\FeatureChampionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

it('only allows elemental users to champion approved features', function () {
    $feature = createRoadmapFeature(FeatureStatusEnum::Approved);

    $freeUser = User::factory()->create(['pledge' => null]);
    $owlbear = User::factory()->create(['pledge' => Pledge::OWLBEAR]);
    $wyvern = User::factory()->create(['pledge' => Pledge::WYVERN]);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    expect($freeUser->can('champion', $feature))->toBeFalse()
        ->and($owlbear->can('champion', $feature))->toBeFalse()
        ->and($wyvern->can('champion', $feature))->toBeFalse()
        ->and($elemental->can('champion', $feature))->toBeTrue();

    expect(fn () => app(FeatureChampionService::class)->user($wyvern)->champion($feature))
        ->toThrow(AuthorizationException::class);

    // Guest toggle is a no-op
    Livewire::test(Champion::class, ['feature' => $feature])
        ->call('toggle')
        ->assertSet('count', 0);

    // Non-elemental toggle is a no-op
    Livewire::actingAs($wyvern)
        ->test(Champion::class, ['feature' => $feature])
        ->call('toggle')
        ->assertSet('count', 0);

    expect(FeatureChampion::count())->toBe(0);
});

it('rejects championing features that are not approved', function (FeatureStatusEnum $status) {
    $feature = createRoadmapFeature($status);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    expect($elemental->can('champion', $feature))->toBeFalse();
    expect(fn () => app(FeatureChampionService::class)->user($elemental)->champion($feature))
        ->toThrow(AuthorizationException::class);
})->with([
    FeatureStatusEnum::Draft,
    FeatureStatusEnum::Rejected,
    FeatureStatusEnum::Later,
    FeatureStatusEnum::Next,
    FeatureStatusEnum::Now,
    FeatureStatusEnum::Done,
]);

it('allows an elemental to champion an approved feature and increments count', function () {
    $feature = createRoadmapFeature(FeatureStatusEnum::Approved);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    Livewire::actingAs($elemental)
        ->test(Champion::class, ['feature' => $feature])
        ->call('toggle')
        ->assertSet('isChampioned', true)
        ->assertSet('count', 1)
        ->assertDispatched('feature-champions-updated');

    expect(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $feature->id)->exists())->toBeTrue();
});

it('allows multiple elementals to champion the same idea and orders ideas by champions then upvotes', function () {
    $popularByUpvotes = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Many Upvotes', 'upvote_count' => 100]);
    $oneChampion = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'One Champion', 'upvote_count' => 1]);
    $twoChampions = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Two Champions', 'upvote_count' => 0]);

    $e1 = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    $e2 = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    $e3 = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    $service = app(FeatureChampionService::class);
    $service->user($e1)->champion($oneChampion);
    $service->user($e2)->champion($twoChampions);
    $service->user($e3)->champion($twoChampions);

    $orderedIds = Feature::approved()->pluck('id')->all();

    expect($orderedIds)->toBe([
        $twoChampions->id,
        $oneChampion->id,
        $popularByUpvotes->id,
    ]);
});

it('switches an elemental active pick to a new approved idea even if the previous pick is in progress', function () {
    $first = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'First Idea']);
    $second = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Second Idea']);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    $service = app(FeatureChampionService::class)->user($elemental);
    $service->champion($first);

    // Move first feature into Later/Next/Now
    $first->status_id = FeatureStatusEnum::Now;
    $first->saveQuietly();

    $service->champion($second);

    expect(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $first->id)->exists())->toBeFalse()
        ->and(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $second->id)->exists())->toBeTrue();
});

it('allows unchampioning via Champion component and Ideas banner', function () {
    $feature = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Banner Idea']);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    app(FeatureChampionService::class)->user($elemental)->champion($feature);

    Livewire::actingAs($elemental)
        ->test(Champion::class, ['feature' => $feature])
        ->call('toggle')
        ->assertSet('isChampioned', false)
        ->assertSet('count', 0);

    expect(FeatureChampion::count())->toBe(0);

    // Re-champion and remove via Ideas::unchampionActive()
    app(FeatureChampionService::class)->user($elemental)->champion($feature);

    Livewire::actingAs($elemental)
        ->test(Ideas::class)
        ->assertSee('Banner Idea')
        ->call('unchampionActive')
        ->assertDispatched('feature-champions-updated');

    expect(FeatureChampion::count())->toBe(0);
});

it('automatically frees the elemental slot when a championed feature is marked Done while preserving history', function () {
    $first = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Shipped Idea']);
    $second = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Next Idea']);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    $service = app(FeatureChampionService::class)->user($elemental);
    $service->champion($first);

    // Separate admin panel marks feature Done
    $first->status_id = FeatureStatusEnum::Done;
    $first->saveQuietly();

    expect($elemental->activeFeatureChampion()->first())->toBeNull();

    // Elemental can now champion another idea without losing the historical row
    $service->champion($second);

    expect(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $first->id)->exists())->toBeTrue()
        ->and(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $second->id)->exists())->toBeTrue()
        ->and($elemental->activeFeatureChampion()->first()?->feature_id)->toBe($second->id);
});

it('releases active champion slots on subscription end without deleting Done history', function () {
    $doneFeature = createRoadmapFeature(FeatureStatusEnum::Approved);
    $activeFeature = createRoadmapFeature(FeatureStatusEnum::Approved);
    $elemental = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);

    $service = app(FeatureChampionService::class)->user($elemental);
    $service->champion($doneFeature);

    $doneFeature->status_id = FeatureStatusEnum::Done;
    $doneFeature->saveQuietly();

    $service->champion($activeFeature);

    if (! Role::where('name', Pledge::ROLE)->exists()) {
        $role = new Role;
        $role->name = Pledge::ROLE;
        $role->display_name = 'Subscriber';
        $role->save();
    }
    $discord = Mockery::mock(DiscordService::class);
    $discord->shouldReceive('user')->andReturnSelf();
    $discord->shouldReceive('removeRoles')->andReturnSelf();
    app()->instance(DiscordService::class, $discord);

    (new SubscriptionEndJob($elemental))->handle();

    expect(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $activeFeature->id)->exists())->toBeFalse()
        ->and(FeatureChampion::where('user_id', $elemental->id)->where('feature_id', $doneFeature->id)->exists())->toBeTrue();
});

it('displays champion count anonymously without exposing champion usernames', function () {
    $feature = createRoadmapFeature(FeatureStatusEnum::Approved, ['name' => 'Anonymous Idea']);
    $elemental = User::factory()->create([
        'name' => 'SecretElementalUser123',
        'pledge' => Pledge::ELEMENTAL,
    ]);
    $viewer = User::factory()->create(['pledge' => null]);

    app(FeatureChampionService::class)->user($elemental)->champion($feature);

    Livewire::actingAs($viewer)
        ->test(Ideas::class)
        ->assertSee('Anonymous Idea')
        ->assertDontSee('SecretElementalUser123');

    Livewire::actingAs($viewer)
        ->test(Champion::class, ['feature' => $feature, 'count' => 1, 'isChampioned' => false])
        ->assertSee('1')
        ->assertDontSee('SecretElementalUser123');
});

function createRoadmapFeature(FeatureStatusEnum $status, array $attributes = []): Feature
{
    Event::fake();

    $category = new FeatureCategory;
    $category->name = uniqid('roadmap-cat-');
    $category->save();

    foreach (FeatureStatusEnum::cases() as $featureStatus) {
        if (! FeatureStatus::query()->find($featureStatus->value)) {
            $statusModel = new FeatureStatus;
            $statusModel->id = $featureStatus->value;
            $statusModel->name = $featureStatus->name;
            $statusModel->save();
        }
    }

    return Feature::query()->forceCreate(array_merge([
        'name' => 'Feature ' . uniqid(),
        'description' => 'Feature description',
        'category_id' => $category->id,
        'status_id' => $status->value,
        'upvote_count' => 0,
    ], $attributes));
}
