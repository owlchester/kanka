<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Storage;

it('builds the vips dzsave command with native aspect ratio and no square padding', function () {
    $service = new TilingService;

    $command = $service->command('/tmp/source.png', '/tmp/tiles-output');

    expect($command[0])->toBe('vips');
    expect($command[1])->toBe('dzsave');
    expect($command[2])->toBe('/tmp/source.png');
    expect($command[3])->toBe('/tmp/tiles-output');
    expect($command)->toContain('--layout=google');
    expect($command)->toContain('--suffix=.jpg[Q=85]');
    expect($command)->not->toContain('--square'); // no padding to square — native aspect ratio only
});

it('uploads generated tiles to the configured disk, keyed by image, not by a local filesystem path', function () {
    Storage::fake();
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);
    Storage::disk(config('images.disk'))->put($image->path, 'fake-source-bytes');

    // Build a fake local tile-pyramid directory the way `vips dzsave --layout=google` would,
    // simulating its output without actually shelling out to a real vips binary.
    $localTilesDir = sys_get_temp_dir() . '/tiling-service-test-' . uniqid();
    mkdir($localTilesDir . '/0/0', recursive: true);
    file_put_contents($localTilesDir . '/0/0/0.jpg', 'fake-tile-bytes');
    file_put_contents($localTilesDir . '/blank.png', 'fake-blank-bytes');

    $service = new class extends TilingService
    {
        public string $fakeLocalTilesDir;

        public function tileFromFakeVipsOutput(Image $image): void
        {
            $disk = Storage::disk(config('images.disk'));
            $disk->deleteDirectory($image->tilesPath());
            $this->uploadTilesForTest($disk, $this->fakeLocalTilesDir, $image->tilesPath());
        }

        public function uploadTilesForTest($disk, $localTilesDir, $diskPrefix): void
        {
            $reflection = new ReflectionMethod($this, 'uploadTiles');
            $reflection->setAccessible(true);
            $reflection->invoke($this, $disk, $localTilesDir, $diskPrefix);
        }
    };
    $service->fakeLocalTilesDir = $localTilesDir;

    $service->tileFromFakeVipsOutput($image);

    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/0/0/0.jpg'))->toBeTrue();
    expect(Storage::disk(config('images.disk'))->get($image->tilesPath() . '/0/0/0.jpg'))->toBe('fake-tile-bytes');
    // blank.png is deliberately not uploaded — the app has its own transparent-tile fallback
    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/blank.png'))->toBeFalse();

    // Cleanup the local fixture dir this test created directly (not exercised via the real tile()/finally path)
    exec('rm -rf ' . escapeshellarg($localTilesDir));
});

it('tile() downloads the source to a real local file, runs the command against it, and uploads results back to the configured disk', function () {
    Storage::fake();
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);
    Storage::disk(config('images.disk'))->put($image->path, 'fake-source-bytes');

    $service = new class extends TilingService
    {
        public ?string $capturedLocalSource = null;

        public ?string $capturedLocalTilesDir = null;

        public function command(string $localSourcePath, string $localTilesDir): array
        {
            $this->capturedLocalSource = $localSourcePath;
            $this->capturedLocalTilesDir = $localTilesDir;

            // Instead of shelling out to a real `vips` binary, fabricate the output
            // directory structure `vips dzsave --layout=google` would have produced,
            // so we can assert `tile()` genuinely reads from a local path and uploads
            // the results back to the (fake) configured disk.
            mkdir($localTilesDir . '/0/0', recursive: true);
            file_put_contents($localTilesDir . '/0/0/0.jpg', 'fake-tile-bytes');

            // A harmless no-op command so Process::mustRun() succeeds without vips installed.
            return ['true'];
        }
    };

    $service->tile($image);

    // The local source file was really downloaded from the disk (not just Storage::path()'d).
    expect($service->capturedLocalSource)->not->toBeNull();
    expect(file_exists($service->capturedLocalSource))->toBeFalse(); // cleaned up in the `finally` block
    expect(file_exists($service->capturedLocalTilesDir))->toBeFalse(); // cleaned up in the `finally` block

    // The generated tile was uploaded back to the configured (fake) disk, image-keyed.
    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/0/0/0.jpg'))->toBeTrue();
    expect(Storage::disk(config('images.disk'))->get($image->tilesPath() . '/0/0/0.jpg'))->toBe('fake-tile-bytes');
});
