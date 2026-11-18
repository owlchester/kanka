<?php

use App\Enums\CampaignImportStatus;
use App\Enums\UserAction;
use App\Jobs\Campaigns\Import as ValidateImport;
use App\Jobs\Campaigns\ImportCsv;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\User;
use App\Services\CsvImportService;
use App\Services\CsvValidatorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
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

it('fails imports whose CSV is not UTF-8 encoded', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/invalid-encoding.csv";
    Storage::disk('export')->put($key, "\xFFname\nAlice\n");

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();

    $job = new ValidateImport($import);

    try {
        $job->handle();
        $this->fail('Expected CSV validation to fail.');
    } catch (RuntimeException $exception) {
        expect($exception->getMessage())->toBe(__('campaigns/import.csv.encoding_error'));
        $job->failed($exception);
    }

    expect($import->fresh()->status_id)->toBe(CampaignImportStatus::FAILED)
        ->and($import->fresh()->errors)->toBe([__('campaigns/import.csv.encoding_error')])
        ->and(Storage::disk('export')->exists($key))->toBeFalse();
});

it('cleans up a failed CSV import before downloading the file', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/missing.csv";

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();

    app(CsvImportService::class)
        ->job($import)
        ->fail(new RuntimeException('Unable to download CSV.'));

    expect($import->fresh()->status_id)->toBe(CampaignImportStatus::FAILED)
        ->and($import->fresh()->errors)->toBe(['Unable to download CSV.']);
});

it('fails an import when the export CSV is missing without attempting to parse it', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Storage::fake('local');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/missing.csv";
    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();
    $job = new ImportCsv($import, $user->id, config('entities.ids.character'), [], [], [], []);

    try {
        $job->handle();
        $this->fail('Expected CSV download to fail.');
    } catch (RuntimeException $exception) {
        expect($exception->getMessage())->toBe(__('campaigns/import.csv.download_error'));
        $job->failed($exception);
    }

    expect($import->fresh()->status_id)->toBe(CampaignImportStatus::FAILED)
        ->and($import->fresh()->errors)->toBe([__('campaigns/import.csv.download_error')])
        ->and(Entity::where('campaign_id', $campaign->id)->count())->toBe(0);
});

it('fails an import when saving the downloaded CSV fails', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Notification::fake();

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/write-failure.csv";
    Storage::disk('export')->put($key, "name\nAlice\n");

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::QUEUED;
    $import->config = ['files' => [$key]];
    $import->save();

    $exportDisk = Storage::disk('export');
    $localDisk = Mockery::mock();
    $localDisk->shouldReceive('put')->once()->andReturnFalse();
    Storage::shouldReceive('disk')->with('export')->andReturn($exportDisk);
    Storage::shouldReceive('disk')->with('local')->andReturn($localDisk);

    $job = new ImportCsv($import, $user->id, config('entities.ids.character'), [], [], [], []);

    try {
        $job->handle();
        $this->fail('Expected local CSV write to fail.');
    } catch (RuntimeException $exception) {
        expect($exception->getMessage())->toBe(__('campaigns/import.csv.local_write_error'));
        $job->failed($exception);
    }

    expect($import->fresh()->status_id)->toBe(CampaignImportStatus::FAILED)
        ->and($import->fresh()->errors)->toBe([__('campaigns/import.csv.local_write_error')])
        ->and(Entity::where('campaign_id', $campaign->id)->count())->toBe(0);
});

it('imports a CSV using the local disk and cleans up the downloaded file', function () {
    $this->asUser()->withCampaign();
    Storage::fake('export');
    Storage::fake('local');
    Notification::fake();
    DB::purge('logs');
    config(['database.connections.logs' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => false,
    ]]);
    Schema::connection('logs')->create('user_logs', function ($table): void {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->unsignedTinyInteger('type_id')->default(UserAction::login->value);
        $table->unsignedBigInteger('campaign_id')->nullable();
        $table->json('data')->nullable();
        $table->unsignedInteger('impersonated_by')->nullable();
        $table->string('ip', 255)->nullable();
        $table->char('country', 6)->nullable();
        $table->timestamps();
    });

    $campaign = Campaign::firstOrFail();
    $user = User::firstOrFail();
    $key = "campaigns/{$campaign->id}/imports/success.csv";
    Storage::disk('export')->put($key, "name,entry\nAlice,An adventurer\n");

    $import = new CampaignImport;
    $import->campaign_id = $campaign->id;
    $import->user_id = $user->id;
    $import->status_id = CampaignImportStatus::READY;
    $import->config = ['files' => [$key]];
    $import->save();

    $job = new ImportCsv(
        $import,
        $user->id,
        config('entities.ids.character'),
        ['name' => 0, 'entry' => 1],
        [],
        [],
        [],
    );
    $job->handle();

    expect($import->fresh()->status_id)->toBe(CampaignImportStatus::FINISHED)
        ->and(Entity::where('campaign_id', $campaign->id)->where('name', 'Alice')->exists())->toBeTrue()
        ->and(Storage::disk('export')->exists($key))->toBeFalse()
        ->and(collect(Storage::disk('local')->allFiles())
            ->filter(fn (string $file): bool => str_ends_with($file, '.csv'))
            ->isEmpty())->toBeTrue();
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
        'age' => '42',
        'traits' => ['personalities' => [], 'appearances' => []],
    ]);
    $service->create();

    $character = Character::where('campaign_id', $campaign->id)->firstOrFail();
    $entity = Entity::where('entity_id', $character->id)->firstOrFail();

    expect((bool) $entity->is_private)->toBeFalse()
        ->and($entity->created_by)->toBe($user->id)
        ->and($entity->entry)->not->toContain('<script')
        ->and($character->age)->toBe('42')
        ->and($character->getRawOriginal('name'))->toBeNull()
        ->and($entity->name)->toBe('Alice')
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
