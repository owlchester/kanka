<?php

use App\Datagrids\Filters\CustomEntityFilter;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Location;
use App\Services\Entity\ColumnDefinitionService;
use App\Services\FilterService;
use Illuminate\Http\Request;

function makeGadgetEntityType(): EntityType
{
    $entityType = new EntityType([
        'code' => 'gadget',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $entityType->campaign_id = 1;
    $entityType->singular = 'Gadget';
    $entityType->plural = 'Gadgets';
    $entityType->icon = 'fa-solid fa-gear';
    $entityType->save();

    return $entityType;
}

it('includes locations in custom entity list columns and relation loading', function () {
    $this->asUser()->withCampaign()->withLocations();

    $entityType = makeGadgetEntityType();
    $service = app(ColumnDefinitionService::class);

    $campaign = Campaign::findOrFail(1);
    expect(array_column($service->columns($entityType, $campaign), 'key'))
        ->toContain('locations')
        ->and($service->relationMap($entityType, $campaign))
        ->toContain('locations.entity');
});

it('renders plural locations filter names for custom entity lists', function () {
    $this->asUser()->withCampaign()->withLocations();
    $type = makeGadgetEntityType();
    $filter = app(CustomEntityFilter::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type);
    $filter->build();

    $locationFilter = collect($filter->filters())->firstWhere('field', 'locations');
    expect($locationFilter)->not->toBeNull()
        ->and($locationFilter['type'])->toBe('selectMultiple');
});

it('persists custom entity location filters and applies them to entity queries', function () {
    $this->asUser()->withCampaign()->withLocations();
    $type = makeGadgetEntityType();
    $locations = Location::all();
    $matching = new Entity(['campaign_id' => 1, 'entity_id' => 0, 'name' => 'Matching']);
    $matching->type_id = $type->id;
    $matching->save();
    $matching->locations()->attach($locations->first()->id);
    $other = new Entity(['campaign_id' => 1, 'entity_id' => 0, 'name' => 'Other']);
    $other->type_id = $type->id;
    $other->save();

    $makeFilter = function (array $data) use ($type) {
        $filter = app(FilterService::class)
            ->campaign(Campaign::findOrFail(1))
            ->entityType($type)
            ->request(Request::create('/', 'GET', $data));
        $filter->build();

        return $filter;
    };

    $filter = $makeFilter(['locations' => [$locations->first()->id], 'locations_option' => 'include']);
    expect($filter->filters())->toMatchArray([
        'locations' => [$locations->first()->id],
        'locations_option' => 'include',
    ]);

    $restored = $makeFilter([]);
    expect($restored->filters())->toMatchArray($filter->filters());

    $results = Entity::inTypes($type->id)->filter($restored->filters())->pluck('id');
    expect($results)->toContain($matching->id)->not->toContain($other->id);

    expect(Entity::inTypes($type->id)->filter([
        'locations' => [$locations->first()->id],
        'locations_option' => 'exclude',
    ])->pluck('id'))->toContain($other->id)->not->toContain($matching->id);

    expect(Entity::inTypes($type->id)->filter([
        'locations' => [$locations->first()->id],
        'locations_option' => 'none',
    ])->pluck('id'))->toContain($other->id)->not->toContain($matching->id);

    expect(Entity::inTypes($type->id)->filter([
        'locations' => [$locations->first()->id],
        'locations_option' => 'children',
    ])->pluck('id'))->toContain($matching->id)->not->toContain($other->id);
});

it('saves locations when creating a custom entity', function () {
    $this->asUser()->withCampaign(['boost_count' => 4])->withLocations();

    $entityType = makeGadgetEntityType();
    $location = Location::first();

    $this->post(route('entities.store', [1, $entityType]), [
        'name' => 'Widget',
        'save_locations' => 1,
        'locations' => [$location->id],
    ])->assertRedirect();

    $entity = Entity::where('name', 'Widget')->firstOrFail();

    expect($entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$location->id]);
});

it('saves locations when editing a custom entity', function () {
    $this->asUser()->withCampaign(['boost_count' => 4])->withLocations();

    $entityType = makeGadgetEntityType();
    $location = Location::first();

    $entity = new Entity([
        'campaign_id' => 1,
        'entity_id' => 0,
        'name' => 'Widget',
    ]);
    $entity->type_id = $entityType->id;
    $entity->save();

    $this->patch(route('entities.update', [1, $entity]), [
        'name' => 'Widget',
        'save_locations' => 1,
        'locations' => [$location->id],
    ])->assertRedirect();

    expect($entity->locations()->pluck('locations.id')->toArray())
        ->toBe([$location->id]);
});
