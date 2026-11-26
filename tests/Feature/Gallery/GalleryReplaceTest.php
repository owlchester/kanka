<?php

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('replaces an image file in place, increments version, and cleans old file', function () {
    Storage::fake();
    $this->asUser()->withCampaign();

    $image = Image::factory()->create([
        'campaign_id' => 1,
        'ext' => 'png',
        'version' => 1,
        'size' => 100,
    ]);
    $oldPath = $image->path;
    Storage::put($oldPath, 'old-bytes');

    $newFile = UploadedFile::fake()->image('replacement.jpg', 320, 180);

    $this->postJson(route('gallery.file.replace', ['test-campaign', $image]), [
        'file' => $newFile,
    ])
        ->assertOk()
        ->assertJsonPath('data.id', $image->id)
        ->assertJsonPath('data.ext', 'jpg')
        ->assertJsonPath('data.width', 320)
        ->assertJsonPath('data.height', 180);

    $fresh = $image->fresh();
    expect($fresh->version)->toBe(2);
    Storage::assertMissing($oldPath);
    Storage::assertExists($fresh->path);
});

it('rejects replacing a folder', function () {
    $this->asUser()->withCampaign();
    $folder = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true]);

    $this->postJson(route('gallery.file.replace', ['test-campaign', $folder]), [
        'file' => UploadedFile::fake()->image('x.png'),
    ])->assertUnprocessable();
});
