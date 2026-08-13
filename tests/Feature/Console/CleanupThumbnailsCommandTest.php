<?php

use Illuminate\Support\Facades\Storage;

it('reports matching legacy thumbnails without deleting them', function () {
    Storage::fake('s3');
    Storage::disk('s3')->put('calendars/one_thumb.png', str_repeat('a', 100));
    Storage::disk('s3')->put('calendars/nested/two_thumb.jpeg', str_repeat('b', 200));
    Storage::disk('s3')->put('calendars/three.png', str_repeat('c', 300));
    Storage::disk('s3')->put('other/four_thumb.jpg', str_repeat('d', 400));

    $this->artisan('cleanup:thumbnails', ['prefix' => 'calendars'])
        ->expectsOutputToContain('Matched: 2 files')
        ->expectsOutputToContain('Dry run. Nothing was deleted.')
        ->assertSuccessful();

    Storage::disk('s3')->assertExists('calendars/one_thumb.png');
    Storage::disk('s3')->assertExists('calendars/nested/two_thumb.jpeg');
});

it('deletes matching legacy thumbnails when execute is supplied', function () {
    Storage::fake('s3');
    Storage::disk('s3')->put('calendars/one_thumb.png', 'one');
    Storage::disk('s3')->put('calendars/two_thumb.jpg', 'two');
    Storage::disk('s3')->put('calendars/three.jpg', 'three');

    $this->artisan('cleanup:thumbnails', ['prefix' => 'calendars', '--execute' => true])
        ->expectsOutputToContain('Deleted: 2 files')
        ->assertSuccessful();

    Storage::disk('s3')->assertMissing('calendars/one_thumb.png');
    Storage::disk('s3')->assertMissing('calendars/two_thumb.jpg');
    Storage::disk('s3')->assertExists('calendars/three.jpg');
});

it('filters matching thumbnails by maximum size', function () {
    Storage::fake('s3');
    Storage::disk('s3')->put('calendars/small_thumb.png', str_repeat('a', 5 * 1024));
    Storage::disk('s3')->put('calendars/large_thumb.png', str_repeat('b', (5 * 1024) + 1));

    $this->artisan('cleanup:thumbnails', [
        'prefix' => 'calendars',
        '--max-size' => '5kb',
    ])->expectsOutputToContain('Matched: 1 files')->assertSuccessful();

    Storage::disk('s3')->assertExists('calendars/small_thumb.png');
    Storage::disk('s3')->assertExists('calendars/large_thumb.png');
});

it('matches thumbnail suffixes before query parameters', function () {
    Storage::fake('s3');
    Storage::disk('s3')->put('calendars/5df295097efe0_DKIronDire_480x480_thumb.jpg?v=1570217049', 'thumbnail');

    $this->artisan('cleanup:thumbnails', ['prefix' => 'calendars', '--execute' => true])
        ->expectsOutputToContain('Deleted: 1 files')
        ->assertSuccessful();

    Storage::disk('s3')->assertMissing('calendars/5df295097efe0_DKIronDire_480x480_thumb.jpg?v=1570217049');
});

it('rejects an invalid maximum size', function () {
    Storage::fake('s3');

    $this->artisan('cleanup:thumbnails', [
        'prefix' => 'calendars',
        '--max-size' => 'five kb',
    ])->assertFailed();
});
