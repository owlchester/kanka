<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Race;
use App\Models\Tag;
use App\Services\Entity\EntitySaveService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['entities.ids.whiteboard' => EntityType::where('code', 'whiteboard')->value('id')]);
});

it('searches misc models by their entity name', function (string $modelClass) {
    $otherClass = $modelClass === Character::class ? Location::class : Character::class;
    $otherClass::factory()->create(['campaign_id' => 1]);
    /** @var MiscModel $model */
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Legacy name',
    ]);
    $model->entity->update(['name' => 'Canonical entity name']);
    DB::table($model->getTable())->where('id', $model->id)->update(['name' => 'Legacy name']);

    expect($modelClass::search('Canonical entity name')->whereKey($model->id)->exists())->toBeTrue()
        ->and($modelClass::search('Legacy name')->whereKey($model->id)->exists())->toBeFalse()
        ->and($modelClass::search('Canonical entity name')->firstOrFail()->id)->toBe($model->id);
})->with('misc models');

it('serializes canonical entity names instead of legacy child names', function (string $modelClass) {
    /** @var MiscModel $model */
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Legacy name',
    ]);
    $model->entity->update(['name' => 'Canonical entity name']);
    DB::table($model->getTable())->where('id', $model->id)->update(['name' => 'Legacy name']);

    $fresh = $model->fresh();
    $data = method_exists($fresh, 'export') ? json_decode($fresh->export(), true) : $fresh->toArray();
    expect($data['name'])->toBe('Canonical entity name');
})->with('misc models');

it('keeps entity-backed child name columns null on creation and updates', function (string $modelClass) {
    /** @var MiscModel $model */
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Initial name',
    ]);

    expect($model->getRawOriginal('name'))->toBeNull()
        ->and($model->entity->name)->toBe('Initial name');

    $model->entity->update(['name' => 'Renamed entity']);

    expect($model->fresh()->getRawOriginal('name'))->toBeNull()
        ->and(Entity::findOrFail($model->entity->id)->name)->toBe('Renamed entity');
})->with('misc models');

it('creates renames searches and serializes misc models without child name columns', function (string $modelClass) {
    $table = (new $modelClass)->getTable();
    foreach (Schema::getIndexes($table) as $index) {
        if (in_array('name', $index['columns'], true)) {
            Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropIndex($index['name']));
        }
    }
    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropColumn('name'));

    $model = $modelClass::factory()->create(['campaign_id' => 1, 'name' => 'Before rename']);
    app(EntitySaveService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entity($model->entity)
        ->skipPermissions()
        ->save(['name' => 'After rename']);

    expect($model->fresh()->name)->toBe('After rename')
        ->and($model->fresh()->toArray()['name'])->toBe('After rename')
        ->and($modelClass::search('After rename')->whereKey($model->id)->exists())->toBeTrue()
        ->and($model->fresh()->isFillable('name'))->toBeFalse();

    $fresh = $model->fresh();
    if (method_exists($fresh, 'export')) {
        expect(json_decode($fresh->export(), true)['name'])->toBe('After rename');
    }

    $last = $modelClass::factory()->create(['campaign_id' => 1, 'name' => 'Z last']);
    expect($modelClass::query()->order([])->pluck($table . '.id')->all())->toBe([$model->id, $last->id]);
    if (method_exists($model, 'scopeSort')) {
        expect($modelClass::query()->sort(['k' => 'name', 'o' => 'desc'])->pluck($table . '.id')->all())
            ->toBe([$last->id, $model->id]);
    }
})->with('misc models');

it('transforms into every misc type without child name columns', function (string $modelClass) {
    $target = new $modelClass;
    foreach (Schema::getIndexes($target->getTable()) as $index) {
        if (in_array('name', $index['columns'], true)) {
            Schema::table($target->getTable(), fn (Blueprint $blueprint) => $blueprint->dropIndex($index['name']));
        }
    }
    Schema::table($target->getTable(), fn (Blueprint $blueprint) => $blueprint->dropColumn('name'));
    $sourceClass = $modelClass === Character::class ? Location::class : Character::class;
    $source = $sourceClass::factory()->create(['campaign_id' => 1, 'name' => 'Transformed name']);
    $id = $source->entity->id;

    $this->postJson('/api/1.0/campaigns/1/transform', [
        'entities' => [$id],
        'entity_type' => $target->entityTypeId(),
    ])->assertSuccessful();

    expect(Entity::findOrFail($id)->child->name)->toBe('Transformed name');
})->with('misc models');

it('sorts characters by canonical race and tag names', function () {
    $first = Character::factory()->create(['campaign_id' => 1]);
    $last = Character::factory()->create(['campaign_id' => 1]);
    foreach ([Race::class => 'races', Tag::class => 'tags'] as $modelClass => $relation) {
        $firstRelated = $modelClass::factory()->create(['campaign_id' => 1, 'name' => 'A canonical']);
        $lastRelated = $modelClass::factory()->create(['campaign_id' => 1, 'name' => 'Z canonical']);
        DB::table($firstRelated->getTable())->where('id', $firstRelated->id)->update(['name' => 'Z legacy']);
        DB::table($lastRelated->getTable())->where('id', $lastRelated->id)->update(['name' => 'A legacy']);
        $firstOwner = $relation === 'tags' ? $first->entity : $first;
        $lastOwner = $relation === 'tags' ? $last->entity : $last;
        $firstOwner->{$relation}()->attach($firstRelated->id);
        $lastOwner->{$relation}()->attach($lastRelated->id);
    }

    expect(Character::query()->customSortRaces('asc')->pluck('characters.id')->all())->toBe([$first->id, $last->id])
        ->and(Character::query()->customSortTags('asc')->pluck('characters.id')->all())->toBe([$first->id, $last->id]);
});

it('orders entity queries by canonical tag names', function (bool $dropLegacyName) {
    $first = Character::factory()->create(['campaign_id' => 1, 'name' => 'Z unrelated entity']);
    $last = Character::factory()->create(['campaign_id' => 1, 'name' => 'A unrelated entity']);
    $untagged = Character::factory()->create(['campaign_id' => 1]);
    $firstTag = Tag::factory()->create(['campaign_id' => 1, 'name' => 'A canonical tag']);
    $lastTag = Tag::factory()->create(['campaign_id' => 1, 'name' => 'Z canonical tag']);
    DB::table('tags')->where('id', $firstTag->id)->update(['name' => 'Z legacy tag']);
    DB::table('tags')->where('id', $lastTag->id)->update(['name' => 'A legacy tag']);
    $first->entity->tags()->attach($firstTag->id);
    $last->entity->tags()->attach($lastTag->id);

    if ($dropLegacyName) {
        foreach (Schema::getIndexes('tags') as $index) {
            if (in_array('name', $index['columns'], true)) {
                Schema::table('tags', fn (Blueprint $table) => $table->dropIndex($index['name']));
            }
        }
        Schema::table('tags', fn (Blueprint $table) => $table->dropColumn('name'));
    }

    $ids = [$first->entity->id, $last->entity->id, $untagged->entity->id];
    $orderedIds = fn (string $direction) => Entity::query()
        ->select('entities.*')
        ->whereIn('entities.id', $ids)
        ->order(['tags' => $direction])
        ->pluck('entities.id')->all();

    expect($orderedIds('asc'))->toBe([$untagged->entity->id, $first->entity->id, $last->entity->id])
        ->and($orderedIds('desc'))->toBe([$last->entity->id, $first->entity->id, $untagged->entity->id]);
})->with([
    'with legacy names' => false,
    'without legacy name column' => true,
]);

it('restores legacy child names from entities when the nullable-name migration rolls back', function (string $modelClass) {
    $model = $modelClass::factory()->create([
        'campaign_id' => 1,
        'name' => 'Canonical name',
    ]);
    $migration = require database_path('migrations/2026_10_22_000001_allow_null_entity_backed_child_names.php');

    $migration->down();

    expect(DB::table($model->getTable())->where('id', $model->id)->value('name'))
        ->toBe('Canonical name');

    $migration->up();
})->with('misc models');

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
