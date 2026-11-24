<?php

use App\Services\Caches\ReleaseCacheService;
use App\Services\Images\Img;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

it('does not leak crop, focus, or base state between calls', function () {
    config([
        'thumbor.key' => 'local',
        'thumbor.url' => 'https://thumbor.test/',
        'thumbor.bases.user' => 's3-user/',
        'thumbor.bases.app' => 's3-app/',
    ]);

    $croppedAndFocused = Img::for('avatars/hero.png')
        ->crop(200, 100)
        ->focus(50, 60)
        ->base('app')
        ->url();

    $plain = Img::for('avatars/villain.png')->url();

    expect($croppedAndFocused)
        ->toContain('200x100/')
        ->toContain('filters:focal(40x50:60x70)/')
        ->and($plain)
        ->not->toContain('200x100/')
        ->not->toContain('filters:focal')
        ->toContain('smart/');
});

it('falls back to storage url for svgs and when thumbor is disabled', function () {
    Storage::fake('s3');

    config(['thumbor.key' => 'local', 'thumbor.url' => 'https://thumbor.test/']);
    expect(Img::for('icons/sword.svg')->crop(100, 100)->url())
        ->toBe(Storage::url('icons/sword.svg'));

    config(['thumbor.key' => '']);
    expect(Img::for('avatars/hero.png')->crop(100, 100)->url())
        ->toBe(Storage::url('avatars/hero.png'));
});

it('clears the same release cache key that it populates', function () {
    Cache::put('latest_releases_v3', collect(['cached']), 3600);

    expect(Cache::has('latest_releases_v3'))->toBeTrue();

    app(ReleaseCacheService::class)->clearLatest();

    expect(Cache::has('latest_releases_v3'))->toBeFalse();
});
