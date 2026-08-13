<?php

use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->asUser()->withCampaign();
});

it('moves legacy campaign and header images into the campaign folder', function () {
    $campaign = Campaign::factory()->create([
        'image' => 'w/old-campaign/logo.jpg',
        'header_image' => 'w/old-campaign/header.jpg',
    ]);
    Storage::disk('s3')->put('w/old-campaign/logo.jpg', 'logo');
    Storage::disk('s3')->put('w/old-campaign/header.jpg', 'header');

    $this->artisan('images:fix-campaign-paths', ['--execute' => true])
        ->expectsOutputToContain("{$campaign->id}: image w/old-campaign/logo.jpg -> w/{$campaign->id}/logo.jpg")
        ->expectsOutputToContain("{$campaign->id}: header_image w/old-campaign/header.jpg -> w/{$campaign->id}/header.jpg")
        ->assertSuccessful();

    expect($campaign->fresh()->image)->toBe("w/{$campaign->id}/logo.jpg")
        ->and($campaign->fresh()->header_image)->toBe("w/{$campaign->id}/header.jpg");
    Storage::disk('s3')->assertMissing('w/old-campaign/logo.jpg');
    Storage::disk('s3')->assertMissing('w/old-campaign/header.jpg');
    Storage::disk('s3')->assertExists("w/{$campaign->id}/logo.jpg");
    Storage::disk('s3')->assertExists("w/{$campaign->id}/header.jpg");
});

it('moves root campaigns paths into the campaign folder', function () {
    $campaign = Campaign::factory()->create([
        'image' => 'campaigns/logo.jpg',
        'header_image' => 'campaigns/headers/header.jpg',
    ]);
    Storage::disk('s3')->put('campaigns/logo.jpg', 'logo');
    Storage::disk('s3')->put('campaigns/headers/header.jpg', 'header');

    $this->artisan('images:fix-campaign-paths', ['--execute' => true])
        ->expectsOutputToContain("{$campaign->id}: image campaigns/logo.jpg -> w/{$campaign->id}/logo.jpg")
        ->expectsOutputToContain("{$campaign->id}: header_image campaigns/headers/header.jpg -> w/{$campaign->id}/header.jpg")
        ->assertSuccessful();

    expect($campaign->fresh()->image)->toBe("w/{$campaign->id}/logo.jpg")
        ->and($campaign->fresh()->header_image)->toBe("w/{$campaign->id}/header.jpg");
    Storage::disk('s3')->assertMissing('campaigns/logo.jpg');
    Storage::disk('s3')->assertMissing('campaigns/headers/header.jpg');
    Storage::disk('s3')->assertExists("w/{$campaign->id}/logo.jpg");
    Storage::disk('s3')->assertExists("w/{$campaign->id}/header.jpg");
});

it('does not change already-correct paths or files during a dry run', function () {
    $campaign = Campaign::factory()->create(['header_image' => 'w/other/header.jpg']);
    $campaign->updateQuietly(['image' => "w/{$campaign->id}/already.jpg"]);
    Storage::disk('s3')->put('w/other/header.jpg', 'header');

    $this->artisan('images:fix-campaign-paths')
        ->expectsOutputToContain("{$campaign->id}: header_image w/other/header.jpg -> w/{$campaign->id}/header.jpg")
        ->expectsTable(['Metric', 'Count'], [
            ['Candidates', 1],
            ['Repaired', 0],
            ['Missing sources', 0],
            ['Destination conflicts', 0],
            ['Failures', 0],
        ])
        ->assertSuccessful();

    expect($campaign->fresh()->image)->toBe("w/{$campaign->id}/already.jpg")
        ->and($campaign->fresh()->header_image)->toBe('w/other/header.jpg');
    Storage::disk('s3')->assertExists('w/other/header.jpg');
    Storage::disk('s3')->assertMissing("w/{$campaign->id}/header.jpg");
});

it('reports missing sources and destination conflicts without changing campaign paths', function () {
    $missing = Campaign::factory()->create(['image' => 'w/missing/image.jpg']);
    $conflict = Campaign::factory()->create(['header_image' => 'w/old/header.jpg']);
    Storage::disk('s3')->put('w/old/header.jpg', 'source');
    Storage::disk('s3')->put("w/{$conflict->id}/header.jpg", 'destination');

    $this->artisan('images:fix-campaign-paths', ['--execute' => true])
        ->expectsOutputToContain('Source does not exist: w/missing/image.jpg')
        ->expectsOutputToContain("Destination already exists: w/{$conflict->id}/header.jpg")
        ->expectsTable(['Metric', 'Count'], [
            ['Candidates', 2],
            ['Repaired', 0],
            ['Missing sources', 1],
            ['Destination conflicts', 1],
            ['Failures', 0],
        ])
        ->assertSuccessful();

    expect($missing->fresh()->image)->toBe('w/missing/image.jpg')
        ->and($conflict->fresh()->header_image)->toBe('w/old/header.jpg');
    Storage::disk('s3')->assertExists('w/old/header.jpg');
});

it('updates both fields when they reference the same legacy file', function () {
    $campaign = Campaign::factory()->create([
        'image' => 'w/old/shared.jpg',
        'header_image' => 'w/old/shared.jpg',
    ]);
    Storage::disk('s3')->put('w/old/shared.jpg', 'shared');

    $this->artisan('images:fix-campaign-paths', ['--execute' => true])
        ->expectsTable(['Metric', 'Count'], [
            ['Candidates', 2],
            ['Repaired', 2],
            ['Missing sources', 0],
            ['Destination conflicts', 0],
            ['Failures', 0],
        ])
        ->assertSuccessful();

    expect($campaign->fresh()->image)->toBe("w/{$campaign->id}/shared.jpg")
        ->and($campaign->fresh()->header_image)->toBe("w/{$campaign->id}/shared.jpg");
    Storage::disk('s3')->assertMissing('w/old/shared.jpg');
    Storage::disk('s3')->assertExists("w/{$campaign->id}/shared.jpg");
});
