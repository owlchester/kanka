<?php

use App\Enums\CampaignVisibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Renderers\DatagridRenderer2;
use App\Services\Campaign\LocalisationService;
use App\Services\Entity\ColumnDefinitionService;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

it('redirects legacy children routes from the child id to the entity id', function (string $type) {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $creation = app(StandardEntityCreationService::class)->campaign($campaign);
    $creation->entityType(EntityType::findOrFail(config('entities.ids.character')))->create(['name' => 'Unrelated']);
    $child = $creation->entityType(EntityType::findOrFail(config("entities.ids.$type")))->create(['name' => 'Parent']);
    $module = $child->entity->entityType->pluralCode();

    expect($child->id)->not->toBe($child->entity->id);
    $this->get(route("$module.$module", [$campaign, $child]))
        ->assertRedirect(route('entities.children', [$campaign, $child->entity]));
})->with([
    'ability', 'creature', 'event', 'family', 'item', 'journal', 'location',
    'map', 'note', 'organisation', 'quest', 'race', 'tag', 'timeline',
]);

it('checks guest visibility before redirecting legacy children routes', function (bool $private) {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public->value]);
    $campaign = Campaign::findOrFail(1);
    $child = app(StandardEntityCreationService::class)->campaign($campaign)
        ->entityType(EntityType::findOrFail(config('entities.ids.note')))
        ->create(['name' => 'Parent', 'is_private' => $private]);

    Auth::forgetGuards();
    Auth::shouldUse('web');
    $this->withoutMiddleware(ReplicationSwitcher::class);

    $response = $this->get(route('notes.notes', [$campaign, $child]));
    if ($private) {
        $response->assertForbidden();
    } else {
        $response->assertRedirect(route('entities.children', [$campaign, $child->entity]));
    }
})->with(['public' => false, 'private' => true]);

it('does not resolve deleted or foreign children through a legacy route', function () {
    $this->asUser()->withCampaign()->withCampaigns();
    $creation = app(StandardEntityCreationService::class)
        ->entityType(EntityType::findOrFail(config('entities.ids.note')));
    $local = $creation->campaign(Campaign::findOrFail(1))->create(['name' => 'Deleted parent']);
    $foreign = $creation->campaign(Campaign::findOrFail(2))->create(['name' => 'Foreign parent']);
    $local->entity->delete();

    $this->get(route('notes.notes', [1, $local]))->assertNotFound();
    $this->get(route('notes.notes', [1, $foreign]))->assertNotFound();
});

test('the entity children datagrid renders and does not load the heavy entities.entry/tooltip columns', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $parent = Character::find(1)->entity;
    $child = Character::find(2)->entity;
    $child->parent_id = $parent->id;
    $child->save();
    $campaign = Campaign::find(1);

    app()->forgetInstance(LocalisationService::class);
    app()->forgetInstance(DatagridRenderer2::class);
    Facade::clearResolvedInstance('campaignlocalization');
    Facade::clearResolvedInstance('datagrid');

    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    $hydrations = [];
    Entity::retrieved(function (Entity $retrieved) use (&$hydrations) {
        $hydrations[] = ['id' => $retrieved->id, 'attributes' => array_keys($retrieved->getAttributes())];
    });

    $response = $this->get(route('entities.children', [$campaign, $parent]));

    $response->assertStatus(200);
    $response->assertSee($child->name, false);
    $rowEntityHydrations = array_filter($hydrations, fn (array $h) => $h['id'] !== $parent->id);
    expect($rowEntityHydrations)->not->toBeEmpty();

    foreach ($rowEntityHydrations as $hydration) {
        expect($hydration['attributes'])->not->toContain('entry');
        expect($hydration['attributes'])->not->toContain('tooltip');
    }
});

test('children optional columns follow the parent module capabilities', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $columns = app(ColumnDefinitionService::class)->childrenColumns(
        EntityType::where('code', 'map')->firstOrFail(),
        $campaign,
    );

    expect(array_column($columns, 'key'))->not->toContain('status')
        ->not->toContain('calendar_date');
});
