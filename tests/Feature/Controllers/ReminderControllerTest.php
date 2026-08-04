<?php

use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Renderers\DatagridRenderer2;
use App\Services\Campaign\LocalisationService;
use Illuminate\Support\Facades\Facade;

test('the entity reminders datagrid renders and does not load the heavy entities.entry/tooltip columns', function () {
    $this->asUser()->withCampaign()->withCharacters()->withCalendars();
    $entity = Character::find(1)->entity;
    $calendar = Calendar::find(1);
    $campaign = Campaign::find(1);

    $entity->reminders()->create([
        'calendar_id' => $calendar->id,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
        'visibility_id' => 1,
    ]);

    // DatagridRendererProvider/CampaignLocalizationServiceProvider resolve as singletons and cache
    // whatever Request object is bound in the container the first time they're touched. Test setup
    // above (asUser()/withCampaign()) already triggers that first resolution against the CLI-bootstrap
    // request (no route), and Facade::$resolvedInstance caches it independent of the container's own
    // singleton cache, so app()->forgetInstance() alone doesn't invalidate it. Clear both caches so the
    // Datagrid-backed reminders tab sees the real routed request/campaign below.
    app()->forgetInstance(LocalisationService::class);
    app()->forgetInstance(DatagridRenderer2::class);
    Facade::clearResolvedInstance('campaignlocalization');
    Facade::clearResolvedInstance('datagrid');

    // layouts.footer unconditionally references LARAVEL_START (normally defined by public/index.php,
    // which the test HTTP kernel never executes). Define it here, same as production does.
    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    // Inspect the attributes actually hydrated on every Entity retrieved during the request,
    // rather than the raw SQL: a plain "select *" wouldn't otherwise be caught here (e.g. sqlite
    // renders it without column names), but hydrated attributes reveal exactly what was selected.
    // The route-bound $entity itself is fetched via route model binding (a separate, full select
    // that is out of scope here) so it's excluded - what we care about is the datagrid *row* data,
    // i.e. the reminder's related calendar entity.
    $hydrations = [];
    Entity::retrieved(function (Entity $retrieved) use (&$hydrations) {
        $hydrations[] = ['id' => $retrieved->id, 'attributes' => array_keys($retrieved->getAttributes())];
    });

    $response = $this->get(route('entities.reminders.index', [$campaign, $entity]));

    $response->assertStatus(200);
    $response->assertSee($entity->name, false);

    $rowEntityHydrations = array_filter($hydrations, fn (array $h) => $h['id'] !== $entity->id);
    expect($rowEntityHydrations)->not->toBeEmpty();

    foreach ($rowEntityHydrations as $hydration) {
        expect($hydration['attributes'])->not->toContain('entry');
        expect($hydration['attributes'])->not->toContain('tooltip');
    }
});
