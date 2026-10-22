<?php

use App\Models\Character;
use App\Models\Family;
use App\Models\Location;

beforeEach(function () {
    $this->asUser()->withCampaign();
});

it('searches characters, families, and locations by their entity name', function (string $modelClass) {
    /** @var Character|Family|Location $model */
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Legacy name',
    ]);
    $model->entity->update(['name' => 'Canonical entity name']);

    expect($modelClass::search('Canonical entity name')->whereKey($model->id)->exists())->toBeTrue()
        ->and($modelClass::search('Legacy name')->whereKey($model->id)->exists())->toBeFalse();
})->with([
    'character' => Character::class,
    'family' => Family::class,
    'location' => Location::class,
]);

it('exports canonical entity names instead of legacy child names', function (string $modelClass) {
    /** @var Character|Family|Location $model */
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Legacy name',
    ]);
    $model->entity->update(['name' => 'Canonical entity name']);

    expect(json_decode($model->fresh()->export(), true)['name'])->toBe('Canonical entity name');
})->with([
    'character' => Character::class,
    'family' => Family::class,
    'location' => Location::class,
]);

it('sorts a character by related family and location entity names', function () {
    $familyFirstCharacter = Character::factory()->create(['campaign_id' => 1, 'name' => 'Family first']);
    $familyLastCharacter = Character::factory()->create(['campaign_id' => 1, 'name' => 'Family last']);

    $familyFirst = Family::factory()->create(['campaign_id' => 1, 'name' => 'Z legacy family']);
    $familyFirst->entity->update(['name' => 'A canonical family']);
    $familyFirstCharacter->families()->attach($familyFirst->id);
    $familyLast = Family::factory()->create(['campaign_id' => 1, 'name' => 'A legacy family']);
    $familyLast->entity->update(['name' => 'Z canonical family']);
    $familyLastCharacter->families()->attach($familyLast->id);

    $locationFirstCharacter = Character::factory()->create(['campaign_id' => 1, 'name' => 'Location first']);
    $locationLastCharacter = Character::factory()->create(['campaign_id' => 1, 'name' => 'Location last']);
    $locationFirst = Location::factory()->create(['campaign_id' => 1, 'name' => 'Z legacy location']);
    $locationFirst->entity->update(['name' => 'A canonical location']);
    $locationFirstCharacter->entity->locations()->attach($locationFirst->id);
    $locationLast = Location::factory()->create(['campaign_id' => 1, 'name' => 'A legacy location']);
    $locationLast->entity->update(['name' => 'Z canonical location']);
    $locationLastCharacter->entity->locations()->attach($locationLast->id);

    expect(Character::query()->whereIn('characters.id', [$familyFirstCharacter->id, $familyLastCharacter->id])
        ->customSortFamilies('asc')->pluck('characters.id')->all())
        ->toBe([$familyFirstCharacter->id, $familyLastCharacter->id])
        ->and(Character::query()->whereIn('characters.id', [$locationFirstCharacter->id, $locationLastCharacter->id])
            ->customSortLocations('asc')->pluck('characters.id')->all())
        ->toBe([$locationFirstCharacter->id, $locationLastCharacter->id]);
});
