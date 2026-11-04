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

it('saves an installed campaign sheet when creating an entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
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
    });
    Schema::create('campaign_plugins', function (Blueprint $table): void {
        $table->increments('id');
        $table->unsignedInteger('campaign_id');
        $table->unsignedInteger('plugin_id');
        $table->unsignedInteger('plugin_version_id');
        $table->boolean('is_active');
    });

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
