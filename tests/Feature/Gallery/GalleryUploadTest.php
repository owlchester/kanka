<?php

use App\Models\Campaign;
use App\Models\Image;
use Illuminate\Http\UploadedFile;

it('uploads a file into a folder from the current campaign', function () {
    $this->asUser()->withCampaign();

    $folder = Image::factory()->create([
        'campaign_id' => 1,
        'is_folder' => true,
    ]);

    $this->postJson(route('gallery.upload.files', 'test-campaign'), [
        'files' => [UploadedFile::fake()->image('map.png')],
        'folder_id' => $folder->id,
    ])->assertSuccessful();

    expect(Image::query()
        ->where('campaign_id', 1)
        ->where('folder_id', $folder->id)
        ->where('name', 'map')
        ->exists())->toBeTrue();
});

it('rejects an undefined folder id', function () {
    $this->asUser()->withCampaign();

    $this->postJson(route('gallery.upload.files', 'test-campaign'), [
        'files' => [UploadedFile::fake()->image('map.png')],
        'folder_id' => 'undefined',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('folder_id');

    expect(Image::query()->exists())->toBeFalse();
});

it('rejects a gallery image as an upload folder', function () {
    $this->asUser()->withCampaign();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'is_folder' => false,
    ]);

    $this->postJson(route('gallery.upload.files', 'test-campaign'), [
        'files' => [UploadedFile::fake()->image('map.png')],
        'folder_id' => $image->id,
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('folder_id');

    expect(Image::query()->count())->toBe(1);
});

it('rejects an upload folder from another campaign', function () {
    $this->asUser()->withCampaign();

    $otherCampaign = Campaign::factory()->create();
    $folder = Image::factory()->create([
        'campaign_id' => $otherCampaign->id,
        'is_folder' => true,
    ]);

    $this->postJson(route('gallery.upload.files', 'test-campaign'), [
        'files' => [UploadedFile::fake()->image('map.png')],
        'folder_id' => $folder->id,
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('folder_id');

    expect(Image::query()->count())->toBe(1);
});
