<?php

use Illuminate\Support\Facades\Schema;

it('adds tiling columns to images and maps, and drops the dead chunking columns', function () {
    expect(Schema::hasColumn('images', 'tiling_status'))->toBeTrue();
    expect(Schema::hasColumn('images', 'tiling_error'))->toBeTrue();
    expect(Schema::hasColumn('maps', 'tiling_prompt_dismissed_at'))->toBeTrue();
    expect(Schema::hasColumn('maps', 'chunking_status'))->toBeFalse();
    expect(Schema::hasColumn('map_markers', 'chunking_status'))->toBeFalse();
});

it('defaults the tiling threshold config to 10 MiB', function () {
    expect(config('maps.tiling_threshold_kb'))->toBe(10 * 1024);
});
