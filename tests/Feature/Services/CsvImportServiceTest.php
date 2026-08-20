<?php

use App\Enums\CampaignImportStatus;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\User;
use App\Services\CsvImportService;
use App\Services\CsvValidatorService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

it('keeps the original index for fully filled columns', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/index.csv";
    Storage::disk('export')->put($key, "optional,name\n,Alice\nvalue,Bob\n");

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();

    app(CsvValidatorService::class)->job($import)->run();

    expect($import->fresh()->config['filled_columns'])->toBe([1 => 'name']);
});

it('does not mark missing trailing values as fully filled', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/short.csv";
    Storage::disk('export')->put($key, "optional,name\nvalue,Alice\nvalue\n");

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();

    app(CsvValidatorService::class)->job($import)->run();

    expect($import->fresh()->config['filled_columns'])->toBe([0 => 'optional']);
});

it('imports canonical entity data safely with explicit public privacy', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');

    $campaign = Campaign::firstOrFail();
    $campaign->entity_visibility = true;
    $campaign->save();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/character.csv";
    Storage::disk('export')->put(
        $key,
        "name,entry,is_private,age\nAlice,\"<script>alert(1)</script>\",false,42\n"
    );

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::READY;
    $import->config = ['files' => [$key]];
    $import->save();

    $service = app(CsvImportService::class)
        ->job($import)
        ->entityType(EntityType::findOrFail(config('entities.ids.character')));
    $data = new ReflectionProperty(CsvImportService::class, 'data');
    $data->setValue($service, [
        'name' => 'Alice',
        'entry' => '<script>alert(1)</script>',
        'is_private' => false,
        'age' => 42,
        'traits' => ['personalities' => [], 'appearances' => []],
    ]);
    $service->create();

    $character = Character::where('campaign_id', $campaign->id)->firstOrFail();
    $entity = Entity::where('entity_id', $character->id)->firstOrFail();

    expect((bool) $entity->is_private)->toBeFalse()
        ->and($entity->created_by)->toBe($user->id)
        ->and($entity->entry)->not->toContain('<script')
        ->and($character->age)->toBe('42')
        ->and($entity->entity_id)->toBe($character->id);
});

it('does not expose an import from another campaign', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $otherCampaign = Campaign::factory()->create(['slug' => 'other-campaign']);
    $import = new CampaignImport;
    $import->campaign_id = $otherCampaign->id;
    $import->user_id = User::firstOrFail()->id;
    $import->status_id = CampaignImportStatus::READY;
    $import->config = ['files' => []];
    $import->save();

    $this->get(route('campaign.import.csv', [$campaign, $import]))
        ->assertForbidden();
});
