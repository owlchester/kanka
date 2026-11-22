<?php

use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\EntitySheetService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('can remove a legacy sheet without removing shared entity attributes', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::firstOrFail();
    $campaign = Campaign::firstOrFail();
    $attribute = Attribute::factory()->create([
        'entity_id' => $entity->id,
        'name' => 'strength',
        'value' => 12,
    ]);
    $entity->sheets()->create([
        'source' => 'legacy',
        'reference' => 'legacy-character-sheet',
        'sort_order' => 0,
    ]);

    app(EntitySheetService::class)
        ->campaign($campaign)
        ->entity($entity)
        ->sync([]);

    expect($entity->sheets()->exists())->toBeFalse()
        ->and($attribute->fresh()->value)->toBe('12');
});

it('saves sheet state submitted with the attribute editor', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::firstOrFail();
    $legacySheet = $entity->sheets()->create([
        'source' => 'legacy',
        'reference' => 'legacy-character-sheet',
        'sort_order' => 0,
    ]);

    $this->post(route('entities.attributes.save', [Campaign::firstOrFail(), $entity]), [
        'attribute' => [],
        'sheets_present' => '1',
        'sheets' => [json_encode([
            'id' => $legacySheet->id,
            'source' => 'legacy',
            'reference' => $legacySheet->reference,
            'sort_order' => 0,
        ])],
    ])->assertRedirect();

    expect($entity->sheets()->count())->toBe(1)
        ->and($entity->sheets()->first()->reference)->toBe('legacy-character-sheet');
});

it('removes an existing marketplace sheet when the editor submits an empty sheet list', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::firstOrFail();
    $sheet = $entity->sheets()->create([
        'source' => 'marketplace',
        'reference' => 'existing-version-uuid',
        'sort_order' => 0,
    ]);

    $this->post(route('entities.attributes.save', [Campaign::firstOrFail(), $entity]), [
        'attribute' => [],
        'sheets_present' => '1',
    ])->assertRedirect();

    expect($sheet->fresh())->toBeNull()
        ->and($entity->sheets()->exists())->toBeFalse();
});

it('syncs sheets submitted by the main entity edit form', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::firstOrFail();
    $sheet = $entity->sheets()->create([
        'source' => 'legacy',
        'reference' => 'legacy-character-sheet',
        'sort_order' => 0,
    ]);

    $this->patch(route('entities.update', [Campaign::firstOrFail(), $entity]), [
        'name' => $entity->name,
        'sheets_present' => '1',
    ])->assertRedirect();

    expect($sheet->fresh())->toBeNull()
        ->and($entity->sheets()->exists())->toBeFalse();
});

function setUpMarketplaceSheetTables(): void
{
    config(['marketplace.enabled' => true]);

    Schema::create('plugins', function (Blueprint $table): void {
        $table->increments('id');
        $table->uuid('uuid');
        $table->string('name');
        $table->unsignedInteger('type_id');
        $table->unsignedInteger('created_by')->nullable();
        $table->timestamp('deleted_at')->nullable();
    });
    Schema::create('plugin_versions', function (Blueprint $table): void {
        $table->increments('id');
        $table->unsignedInteger('plugin_id');
        $table->uuid('uuid');
        $table->unsignedInteger('status_id');
        $table->text('content')->nullable();
    });
    Schema::create('campaign_plugins', function (Blueprint $table): void {
        $table->increments('id');
        $table->unsignedInteger('campaign_id');
        $table->unsignedInteger('plugin_id');
        $table->unsignedInteger('plugin_version_id');
        $table->boolean('is_active');
    });
}

it('saves an installed campaign sheet when creating an entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    setUpMarketplaceSheetTables();

    $pluginUuid = (string) str()->uuid();
    $versionUuid = (string) str()->uuid();
    DB::table('plugins')->insert([
        'id' => 1,
        'uuid' => $pluginUuid,
        'name' => 'Test sheet',
        'type_id' => 2,
    ]);
    DB::table('plugin_versions')->insert([
        'id' => 1,
        'plugin_id' => 1,
        'uuid' => $versionUuid,
        'status_id' => 3,
    ]);
    DB::table('campaign_plugins')->insert([
        'id' => 1,
        'campaign_id' => 1,
        'plugin_id' => 1,
        'plugin_version_id' => 1,
        'is_active' => true,
    ]);

    $campaign = Campaign::firstOrFail();
    $campaign->boost_count = 1;
    $campaign->saveQuietly();
    $entity = Entity::firstOrFail();
    $entity->sheets()->create([
        'source' => 'marketplace',
        'reference' => $versionUuid,
        'sort_order' => 0,
    ]);
    $this->post(route('characters.store', $campaign), [
        'name' => 'Copied character',
        'copy_source_id' => $entity->id,
        'sheets_present' => '1',
        'sheets' => [json_encode([
            'id' => null,
            'source' => 'marketplace',
            'reference' => $versionUuid,
            'sort_order' => 0,
        ])],
    ])->assertRedirect();

    $createdEntity = Entity::where('name', 'Copied character')->firstOrFail();
    expect($createdEntity->sheets()->where('reference', $versionUuid)->exists())->toBeTrue();
});

it('copies properties and links only available sheets in the destination campaign', function (string $installation, bool $bulk = false) {
    $this->asUser()->withCampaign()->withCampaigns(['boost_count' => 1])->withCharacters();
    setUpMarketplaceSheetTables();

    $source = Entity::where('campaign_id', 1)->firstOrFail();
    $destination = Campaign::findOrFail(2);
    $sourceVersion = (string) str()->uuid();
    $destinationVersion = $installation === 'same version' ? $sourceVersion : (string) str()->uuid();

    DB::table('plugins')->insert([
        'id' => 1,
        'uuid' => (string) str()->uuid(),
        'name' => 'Test sheet',
        'type_id' => 2,
    ]);
    DB::table('plugin_versions')->insert([
        'id' => 1,
        'plugin_id' => 1,
        'uuid' => $sourceVersion,
        'status_id' => 3,
        'content' => 'Source sheet strength: {strength}',
    ]);
    DB::table('campaign_plugins')->insert([
        'campaign_id' => $source->campaign_id,
        'plugin_id' => 1,
        'plugin_version_id' => 1,
        'is_active' => true,
    ]);

    if ($installation !== 'missing') {
        if ($destinationVersion !== $sourceVersion) {
            DB::table('plugin_versions')->insert([
                'id' => 2,
                'plugin_id' => 1,
                'uuid' => $destinationVersion,
                'status_id' => $installation === 'draft' ? 1 : 3,
                'content' => 'Destination sheet strength: {strength}',
            ]);
        }
        DB::table('campaign_plugins')->insert([
            'campaign_id' => $destination->id,
            'plugin_id' => 1,
            'plugin_version_id' => $destinationVersion === $sourceVersion ? 1 : 2,
            'is_active' => $installation !== 'inactive',
        ]);
    }

    $source->sheets()->create([
        'source' => 'marketplace',
        'reference' => $sourceVersion,
        'sort_order' => 2,
    ]);
    if ($installation === 'different version') {
        $source->sheets()->create([
            'source' => 'marketplace',
            'reference' => $destinationVersion,
            'sort_order' => 3,
        ]);
    }
    Attribute::factory()->create([
        'entity_id' => $source->id,
        'name' => 'strength',
        'value' => '12',
    ]);

    if ($bulk) {
        $this->post(route('bulk.copy-to-campaign.apply', [$source->campaign_id, $source->entityType]), [
            'campaign' => $destination->id,
            'models' => (string) $source->id,
        ])->assertRedirect()->assertSessionHas('success_raw');
    } else {
        $this->post(route('entities.move-process', [$source->campaign_id, $source]), [
            'campaign' => $destination->id,
            'copy' => '1',
        ])->assertRedirect()->assertSessionHas('success_raw');
    }

    $copy = Entity::where('campaign_id', $destination->id)->where('name', $source->name)->firstOrFail();
    $expectedSheets = in_array($installation, ['same version', 'different version'])
        ? [['source' => 'marketplace', 'reference' => $destinationVersion, 'sort_order' => 2]]
        : [];

    expect($copy->attributes()->where('name', 'strength')->value('value'))->toBe('12')
        ->and($copy->sheets()->get(['source', 'reference', 'sort_order'])->toArray())->toBe($expectedSheets)
        ->and($source->sheets()->pluck('reference')->all())->toBe(
            $installation === 'different version' ? [$sourceVersion, $destinationVersion] : [$sourceVersion],
        );

    if ($expectedSheets !== []) {
        $this->get(route('entities.attributes', [$destination, $copy]))
            ->assertOk()
            ->assertSee($installation === 'same version' ? 'Source sheet strength: 12' : 'Destination sheet strength: 12');
    }
})->with([
    'same version' => ['same version'],
    'different version via bulk copy' => ['different version', true],
    'not installed' => ['missing'],
    'inactive' => ['inactive'],
    'unpublished for this user' => ['draft'],
]);
