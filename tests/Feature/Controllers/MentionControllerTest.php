<?php

use App\Models\Campaign;
use App\Models\CampaignDescription;
use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Renderers\DatagridRenderer2;
use App\Services\Campaign\LocalisationService;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Carbon;

test('the entity Mentions tab renders a mention for each owner type', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $author = Character::factory()->create(['campaign_id' => 1])->entity;
    $campaign = Campaign::find(1);

    // Entity-owned
    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    // Post-owned
    Post::factory()->create(['entity_id' => $author->id, 'entry' => '[character:' . $target->id . ']']);

    // Campaign-owned (Campaign::$entry is backed by CampaignDescription, not a direct column)
    CampaignDescription::updateOrCreate(
        ['campaign_id' => $campaign->id],
        ['description' => '[character:' . $target->id . ']']
    );

    // DatagridRendererProvider/CampaignLocalizationServiceProvider resolve as singletons and cache
    // whatever Request object is bound in the container the first time they're touched. Test setup
    // above (asUser()/withCampaign()/entry saves) already triggers that first resolution against the
    // CLI-bootstrap request (no route), and Facade::$resolvedInstance caches it independent of the
    // container's own singleton cache, so app()->forgetInstance() alone doesn't invalidate it. Clear
    // both caches so the Datagrid-backed Mentions tab sees the real routed request/campaign below.
    app()->forgetInstance(LocalisationService::class);
    app()->forgetInstance(DatagridRenderer2::class);
    Facade::clearResolvedInstance('campaignlocalization');
    Facade::clearResolvedInstance('datagrid');

    // layouts.footer unconditionally references LARAVEL_START (normally defined by public/index.php,
    // which the test HTTP kernel never executes). Define it here, same as production does.
    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    $response = $this->get(route('entities.mentions', ['campaign' => $campaign, 'entity' => $target]));

    $response->assertStatus(200);
    $response->assertSee('Mentioned');
    $response->assertSee('UTC', false);
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(3);
});

test('the entity Mentions tab displays and sorts mentions by their creation date', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $author = Character::factory()->create(['campaign_id' => 1])->entity;
    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    $mention = EntityMention::where('target_id', $target->id)->firstOrFail();
    $mention->created_at = Carbon::parse('2024-01-01 12:34:56', 'UTC');
    $mention->save();

    $query = EntityMention::query();
    $ascending = $query->clone()->datagridElements(['k' => 'created_at', 'o' => 'asc'])->pluck('entity_mentions.id');
    $descending = $query->clone()->datagridElements(['k' => 'created_at', 'o' => 'desc'])->pluck('entity_mentions.id');

    expect($ascending->first())->toBe($mention->id)
        ->and($descending->last())->toBe($mention->id);
});
