<?php

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config(['filesystems.default' => 's3']);
    Storage::fake('s3');
});

it('defaults to a dry run', function () {
    Storage::disk('s3')->put('w/9001/image.jpg', 'image');

    $this->artisan('cleanup:images')
        ->expectsOutput('This is a dry run. Nothing will get deleted.')
        ->expectsOutput('Would delete 1 images/folders.')
        ->assertSuccessful();

    Storage::disk('s3')->assertExists('w/9001/image.jpg');
});

it('does not delete more folders than the maximum', function () {
    Storage::disk('s3')->put('w/9001/image.jpg', 'image');
    Storage::disk('s3')->put('w/9002/image.jpg', 'image');
    Storage::disk('s3')->put('w/9003/image.jpg', 'image');

    $this->artisan('cleanup:images', [
        '--max' => 1,
        '--execute' => true,
    ])
        ->expectsOutput('Reached max amount of 1')
        ->expectsOutput('Deleted 1 images/folders.')
        ->assertSuccessful();

    expect(Storage::disk('s3')->allFiles('w'))->toHaveCount(2);
});

it('skips non-numeric folders', function () {
    Storage::disk('s3')->put('w/deleted/image.jpg', 'image');
    Storage::disk('s3')->put('w/9001/image.jpg', 'image');

    $this->artisan('cleanup:images', ['--execute' => true])
        ->expectsOutput('Skipped 1 non-numeric folder(s).')
        ->expectsOutput('Deleted 1 images/folders.')
        ->assertSuccessful();

    Storage::disk('s3')->assertExists('w/deleted/image.jpg');
    Storage::disk('s3')->assertMissing('w/9001/image.jpg');
});
