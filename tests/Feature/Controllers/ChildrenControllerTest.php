<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Renderers\DatagridRenderer2;
use App\Services\Campaign\LocalisationService;
use App\Services\Entity\ColumnDefinitionService;
use Illuminate\Support\Facades\Facade;

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
