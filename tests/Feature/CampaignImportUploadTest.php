<?php

use App\Enums\CampaignImportStatus;
use App\Jobs\Campaigns\Import;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Models\Pledge;
use App\Models\User;
use App\Services\Campaign\Import\SignedUploadService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

it('presign — happy path returns URL and sets upload_key', function () {
    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->save();

    $mock = $this->mock(SignedUploadService::class);
    $mock->shouldReceive('campaign')->andReturnSelf();
    $mock->shouldReceive('presign')->andReturnUsing(function (CampaignImport $t, string $ext) use ($campaign) {
        $key = "campaigns/{$campaign->id}/imports/test.{$ext}";
        $t->config = array_merge($t->config ?? [], ['upload_key' => $key]);
        $t->save();

        return ['url' => 'https://fake-s3.example.com/upload'];
    });

    $this->actingAs($user)
        ->postJson(route('campaign.import.presign', [$campaign, $token]), ['ext' => 'zip'])
        ->assertStatus(200)
        ->assertJsonStructure(['url']);

    expect($token->fresh()->config['upload_key'])->toEndWith('.zip');
});

it('presign — user without import permission gets 403', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(); // no pledge
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.presign', [$campaign, $token]), ['ext' => 'zip'])
        ->assertStatus(403);
});

it('presign — token belonging to different campaign gets 403', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaignA = Campaign::first();
    $campaignB = Campaign::factory()->create(['slug' => 'campaign-b']);

    $token = new CampaignImport;
    $token->campaign_id = $campaignB->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.presign', [$campaignA, $token]), ['ext' => 'zip'])
        ->assertStatus(403);
});

it('presign — token not in PREPARED status gets 422', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::QUEUED;
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.presign', [$campaign, $token]), ['ext' => 'zip'])
        ->assertStatus(422);
});

it('confirm — happy path queues import and dispatches job', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $key = "campaigns/{$campaign->id}/imports/test.zip";
    Storage::disk('export')->put($key, 'fake file content');

    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->config = ['upload_key' => $key];
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.confirm', [$campaign, $token]))
        ->assertStatus(200)
        ->assertJson(['success' => true]);

    $fresh = $token->fresh();
    expect($fresh->status_id)->toBe(CampaignImportStatus::QUEUED);
    expect($fresh->config['files'])->toContain($key);
    Bus::assertDispatched(Import::class);
});

it('confirm — file missing on export disk returns 422', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $key = "campaigns/{$campaign->id}/imports/missing.zip";
    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->config = ['upload_key' => $key];
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.confirm', [$campaign, $token]))
        ->assertStatus(422);

    Bus::assertNotDispatched(Import::class);
});

it('confirm — file too large returns 422', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $key = "campaigns/{$campaign->id}/imports/large.zip";
    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->config = ['upload_key' => $key];
    $token->save();

    $mockDisk = Mockery::mock(Filesystem::class);
    $mockDisk->shouldReceive('exists')->with($key)->andReturn(true);
    $mockDisk->shouldReceive('size')->with($key)->andReturn(513 * 1024 * 1024);
    $mockDisk->shouldReceive('delete')->andReturn(true);

    Storage::shouldReceive('disk')->with('export')->andReturn($mockDisk);

    $this->actingAs($user)
        ->postJson(route('campaign.import.confirm', [$campaign, $token]))
        ->assertStatus(422);

    Bus::assertNotDispatched(Import::class);
});

it('confirm — missing upload_key in config returns 422', function () {
    Storage::fake('export');
    Bus::fake();

    $user = User::factory()->create(['pledge' => Pledge::ELEMENTAL]);
    Auth::login($user);
    $this->withCampaign();
    $campaign = Campaign::first();

    $token = new CampaignImport;
    $token->campaign_id = $campaign->id;
    $token->user_id = $user->id;
    $token->status_id = CampaignImportStatus::PREPARED;
    $token->save();

    $this->actingAs($user)
        ->postJson(route('campaign.import.confirm', [$campaign, $token]))
        ->assertStatus(422)
        ->assertJsonFragment(['message' => 'No upload key found.']);

    Bus::assertNotDispatched(Import::class);
});
