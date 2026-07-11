<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Storage;

it('builds the vips dzsave command with native aspect ratio and an image-keyed destination', function () {
    Storage::fake();
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);
    $disk = Storage::disk(config('images.disk'));
    $service = new TilingService;

    $command = $service->command($image, $disk);

    expect($command[0])->toBe('vips');
    expect($command[1])->toBe('dzsave');
    expect($command[2])->toBe($disk->path($image->path));
    expect($command[3])->toBe($disk->path($image->tilesPath()));
    expect($command)->toContain('--layout=google');
    expect($command)->toContain('--suffix=.jpg[Q=85]');
    expect($command)->not->toContain('--square'); // no padding to square — native aspect ratio only
});
