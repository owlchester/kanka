<?php

use App\Models\Campaign;
use App\Models\Image;
use App\Models\User;
use App\Services\Maps\TilingService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

it('builds the vips dzsave command with native aspect ratio, no square padding, and the given suffix', function () {
    $service = new TilingService;

    $command = $service->command('/tmp/source.png', '/tmp/tiles-output', '.png');

    expect($command[0])->toBe('vips');
    expect($command[1])->toBe('dzsave');
    expect($command[2])->toBe('/tmp/source.png');
    expect($command[3])->toBe('/tmp/tiles-output');
    expect($command)->toContain('--layout=google');
    expect($command)->toContain('--suffix=.png');
    expect($command)->not->toContain('--square'); // no padding to square — native aspect ratio only
    expect($command)->toContain('--background=0'); // transparent padding on clipped edge tiles
});

it('defaults the suffix to webp when not specified', function () {
    $service = new TilingService;

    $command = $service->command('/tmp/source.png', '/tmp/tiles-output');

    expect($command)->toContain('--suffix=.webp[Q=80]');
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
    file_put_contents($localTilesDir . '/0/0/0.webp', 'fake-tile-bytes');
    file_put_contents($localTilesDir . '/blank.png', 'fake-blank-bytes');

    $service = new class extends TilingService
    {
        public string $fakeLocalTilesDir;

        public function tileFromFakeVipsOutput(Image $image): void
        {
            $disk = Storage::disk(config('images.disk'));
            $disk->delete($disk->allFiles($image->tilesPath()));
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

    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/0/0/0.webp'))->toBeTrue();
    expect(Storage::disk(config('images.disk'))->get($image->tilesPath() . '/0/0/0.webp'))->toBe('fake-tile-bytes');
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

        public function command(string $localSourcePath, string $localTilesDir, string $suffix = '.webp[Q=80]'): array
        {
            $this->capturedLocalSource = $localSourcePath;
            $this->capturedLocalTilesDir = $localTilesDir;

            // Instead of shelling out to a real `vips` binary, fabricate the output
            // directory structure `vips dzsave --layout=google` would have produced,
            // so we can assert `tile()` genuinely reads from a local path and uploads
            // the results back to the (fake) configured disk.
            mkdir($localTilesDir . '/0/0', recursive: true);
            file_put_contents($localTilesDir . '/0/0/0.webp', 'fake-tile-bytes');

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
    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/0/0/0.webp'))->toBeTrue();
    expect(Storage::disk(config('images.disk'))->get($image->tilesPath() . '/0/0/0.webp'))->toBe('fake-tile-bytes');
});

it('cleans up the local temp source file and tiles directory when the vips process fails, and rethrows', function () {
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

        public function command(string $localSourcePath, string $localTilesDir, string $suffix = '.webp[Q=80]'): array
        {
            $this->capturedLocalSource = $localSourcePath;
            $this->capturedLocalTilesDir = $localTilesDir;

            // Simulate partial vips output written before it fails, to prove cleanup handles
            // that too, not just the "nothing was ever written" case.
            mkdir($localTilesDir . '/0/0', recursive: true);
            file_put_contents($localTilesDir . '/0/0/0.webp', 'partial-tile-bytes');

            // The Unix `false` command always exits 1, causing Process::mustRun() to throw.
            return ['false'];
        }
    };

    expect(fn () => $service->tile($image))->toThrow(ProcessFailedException::class);

    // The local source file was really downloaded before the process ran.
    expect($service->capturedLocalSource)->not->toBeNull();
    expect($service->capturedLocalTilesDir)->not->toBeNull();

    // Both local temp artifacts were still removed, despite the failure (the `finally` block ran).
    expect(file_exists($service->capturedLocalSource))->toBeFalse();
    expect(file_exists($service->capturedLocalTilesDir))->toBeFalse();

    // The failed run's partial output was never uploaded to the disk.
    expect(Storage::disk(config('images.disk'))->exists($image->tilesPath() . '/0/0/0.webp'))->toBeFalse();
});

it('tile() returns the real min/max zoom levels vips generated, not a hardcoded range', function () {
    Storage::fake();
    $user = User::factory()->create();
    $this->actingAs($user);
    $campaign = Campaign::factory()->create();
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'ext' => 'png']);
    Storage::disk(config('images.disk'))->put($image->path, 'fake-source-bytes');

    $service = new class extends TilingService
    {
        public function command(string $localSourcePath, string $localTilesDir, string $suffix = '.webp[Q=80]'): array
        {
            foreach ([0, 1, 2, 3] as $level) {
                mkdir($localTilesDir . '/' . $level, recursive: true);
                file_put_contents($localTilesDir . '/' . $level . '/0_0.webp', 'fake-tile-bytes');
            }

            return ['true'];
        }
    };

    $zoomRange = $service->tile($image);

    expect($zoomRange)->toBe(['min_zoom' => 0, 'max_zoom' => 3]);
});

it('pads clipped edge tiles with a transparent background, not opaque white, via real vips', function () {
    if (! shell_exec('command -v vips')) {
        $this->markTestSkipped('vips is not installed in this environment.');
    }

    $service = new TilingService;

    // 300x300 doesn't divide evenly into 256px tiles, so the bottom-right tile is clipped
    // (only 44x44 of real content) and vips pads the rest of the 256x256 tile — this is exactly
    // the shape that exposed the white-padding bug on a real map image.
    $sourcePath = sys_get_temp_dir() . '/tiling-service-edge-' . uniqid() . '.png';
    $source = imagecreatetruecolor(300, 300);
    imagesavealpha($source, true);
    imagealphablending($source, false);
    imagefill($source, 0, 0, imagecolorallocatealpha($source, 10, 20, 30, 0));
    imagepng($source, $sourcePath);
    imagedestroy($source);

    $localTilesDir = sys_get_temp_dir() . '/tiling-service-edge-output-' . uniqid();

    try {
        $process = new Process($service->command($sourcePath, $localTilesDir));
        $process->mustRun();

        // Native resolution is the deepest level (300x300 needs 2 levels of 256px tiles: 0 and 1).
        $edgeTile = $localTilesDir . '/1/1/1.webp';
        expect(file_exists($edgeTile))->toBeTrue();

        $bands = (int) trim((new Process(['vipsheader', '-f', 'bands', $edgeTile]))->mustRun()->getOutput());
        expect($bands)->toBe(4); // padded region keeps an alpha channel (transparent), not flattened to opaque
    } finally {
        @unlink($sourcePath);
        if (is_dir($localTilesDir)) {
            exec('rm -rf ' . escapeshellarg($localTilesDir));
        }
    }
});
