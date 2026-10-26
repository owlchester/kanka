<?php

use App\Facades\ImportIdMapper;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\EntityMention;
use App\Models\Location;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapMarker;
use App\Models\Organisation;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Services\Campaign\Import\ImportIdMapper as IdMapper;
use App\Services\Campaign\Import\Mappers\CharacterMapper;
use App\Services\Campaign\Import\Mappers\MapMapper;
use App\Services\Campaign\Import\Mappers\TimelineMapper;

beforeEach(function () {
    $this->asUser()->withCampaign()->withCharacters();
    ImportIdMapper::swap(new IdMapper);

    $this->makeMapper = function (string $class, $model) {
        $mapper = app($class)->campaign(Campaign::find(1))->user(auth()->user());
        (new ReflectionProperty($mapper, 'model'))->setValue($mapper, $model);
        (new ReflectionProperty($mapper, 'entity'))->setValue($mapper, $model->entity);

        return $mapper;
    };
});

test('character locations skip missing mappings and deduplicate legacy and current links', function () {
    $character = Character::find(1);
    $location = Location::factory()->create(['campaign_id' => 1]);
    ImportIdMapper::put('locations', 100, $location->id);
    ImportIdMapper::put('characters', 10, $character->id);
    $mapper = ($this->makeMapper)(CharacterMapper::class, $character);
    $mapper->data([
        'id' => 10,
        'location_id' => 999,
        'entity' => ['entityLocations' => [
            ['location_id' => 999],
            ['location_id' => 100],
        ]],
    ]);
    $mapper->second();

    $mapper->data([
        'id' => 10,
        'location_id' => 100,
        'entity' => ['entityLocations' => [['location_id' => 100]]],
    ]);
    $mapper->second();

    expect($character->entity->locations()->pluck('locations.id')->all())->toBe([$location->id]);
});

test('character memberships skip missing organisations and their parent links', function () {
    $character = Character::find(1);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    ImportIdMapper::put('organisations', 100, $organisation->id);
    $mapper = ($this->makeMapper)(CharacterMapper::class, $character);
    $mapper->data(['organisationMemberships' => [
        ['id' => 10, 'organisation_id' => 999],
        ['id' => 11, 'organisation_id' => 100, 'parent_id' => 10, 'role' => 'Member', 'status_id' => 0],
        ['id' => 12, 'organisation_id' => 100, 'parent_id' => 11, 'role' => 'Child', 'status_id' => 0],
    ]]);
    (new ReflectionMethod($mapper, 'memberships'))->invoke($mapper);

    $memberships = CharacterOrganisation::where('character_id', $character->id)->orderBy('id')->get();
    expect($memberships)->toHaveCount(2)
        ->and($memberships[0]->organisation_id)->toBe($organisation->id)
        ->and($memberships[0]->parent_id)->toBeNull()
        ->and($memberships[1]->parent_id)->toBe($memberships[0]->id);
});

test('legacy exports can omit pivot collections', function () {
    $mapper = ($this->makeMapper)(CharacterMapper::class, Character::find(1));
    $mapper->data([]);
    (new ReflectionMethod($mapper, 'pivot'))->invoke($mapper, 'characterFamilies', 'families', 'family_id');
    (new ReflectionMethod($mapper, 'pivot'))->invoke($mapper, 'characterRaces', 'races', 'race_id');

    $this->assertDatabaseCount('character_family', 0);
    $this->assertDatabaseCount('character_race', 0);
});

test('map imports keep groups and markers without unmapped optional group links', function () {
    $map = Map::factory()->create(['campaign_id' => 1]);
    $mapper = ($this->makeMapper)(MapMapper::class, $map);
    $mapper->data([
        'groups' => [
            ['id' => 100, 'name' => 'Root', 'parent_id' => 999],
            ['id' => 101, 'name' => 'Child', 'parent_id' => 100],
        ],
        'markers' => [
            ['name' => 'Ungrouped', 'group_id' => 999, 'latitude' => 0, 'longitude' => 0],
            ['name' => 'Grouped', 'group_id' => 101, 'latitude' => 0, 'longitude' => 0],
            ['name' => 'Missing entity', 'entity_id' => 999],
        ],
    ]);
    foreach (['groups', 'groupsParents', 'markers'] as $method) {
        (new ReflectionMethod($mapper, $method))->invoke($mapper);
    }

    $root = MapGroup::where('map_id', $map->id)->where('name', 'Root')->firstOrFail();
    $child = MapGroup::where('map_id', $map->id)->where('name', 'Child')->firstOrFail();
    expect($root->parent_id)->toBeNull()
        ->and($child->parent_id)->toBe($root->id)
        ->and(MapMarker::where('map_id', $map->id)->count())->toBe(2)
        ->and(MapMarker::where('name', 'Ungrouped')->firstOrFail()->group_id)->toBeNull()
        ->and(MapMarker::where('name', 'Grouped')->firstOrFail()->group_id)->toBe($child->id);
});

test('timeline elements skip missing eras and entities but retain valid elements', function () {
    $timeline = Timeline::factory()->create(['campaign_id' => 1]);
    $mapper = ($this->makeMapper)(TimelineMapper::class, $timeline);
    $mapper->data([
        'eras' => [['id' => 100, 'name' => 'Era']],
        'elements' => [
            ['id' => 10, 'era_id' => 999, 'name' => 'Missing era'],
            ['id' => 11, 'era_id' => 100, 'entity_id' => 999, 'name' => 'Missing entity'],
            ['id' => 12, 'era_id' => 100, 'name' => 'Valid'],
        ],
    ]);
    (new ReflectionMethod($mapper, 'eras'))->invoke($mapper);
    (new ReflectionMethod($mapper, 'elements'))->invoke($mapper);

    expect(TimelineElement::where('timeline_id', $timeline->id)->pluck('name')->all())->toBe(['Valid'])
        ->and(ImportIdMapper::hasTimelineElement(10))->toBeFalse()
        ->and(ImportIdMapper::hasTimelineElement(11))->toBeFalse()
        ->and(ImportIdMapper::hasTimelineElement(12))->toBeTrue();
});

test('mentions check source mappings before trying to resolve them', function (string $field, string $has, string $get) {
    $character = Character::find(1);
    $target = Character::find(2)->entity;
    ImportIdMapper::partialMock()->shouldReceive($get)->never();
    ImportIdMapper::shouldReceive($has)->once()->with(999)->andReturnFalse();
    ImportIdMapper::putEntity(100, $target->id);
    $mapper = ($this->makeMapper)(CharacterMapper::class, $character);
    $mapper->data(['entity' => ['mentions' => [
        ['target_id' => 100, $field => 999],
        ['target_id' => 999, $field => 999],
        ['target_id' => 100],
    ]]]);
    (new ReflectionMethod($mapper, 'foreignMentions'))->invoke($mapper);

    expect(EntityMention::where('target_id', $target->id)->count())->toBe(1);
})->with([
    'post' => ['post_id', 'hasPost', 'getPost'],
    'timeline element' => ['timeline_element_id', 'hasTimelineElement', 'getTimelineElement'],
    'quest element' => ['quest_element_id', 'hasQuestElement', 'getQuestElement'],
]);

test('mention source mapping checks distinguish missing and imported sources', function (string $put, string $has, string $get) {
    expect(ImportIdMapper::$has(100))->toBeFalse();
    ImportIdMapper::$put(100, 200);
    expect(ImportIdMapper::$has(100))->toBeTrue()
        ->and(ImportIdMapper::$get(100))->toBe(200);
})->with([
    ['putPost', 'hasPost', 'getPost'],
    ['putTimelineElement', 'hasTimelineElement', 'getTimelineElement'],
    ['putQuestElement', 'hasQuestElement', 'getQuestElement'],
]);
