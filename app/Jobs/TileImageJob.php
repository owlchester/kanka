<?php

namespace App\Jobs;

use App\Events\Maps\TilingChanged;
use App\Models\Image;
use App\Services\Maps\TilingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TileImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(public Image $image)
    {
        $this->onConnection('heavy');
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [30, 60, 120];
    }

    public function handle(TilingService $service): void
    {
        $service->tile($this->image);

        Image::where('id', $this->image->id)->update([
            'tiling_status' => Image::TILING_FINISHED,
            'tiling_error' => null,
        ]);

        TilingChanged::broadcastForImage($this->image->fresh());
    }

    public function failed(Throwable $e): void
    {
        Image::where('id', $this->image->id)->update([
            'tiling_status' => Image::TILING_ERROR,
            'tiling_error' => $e->getMessage(),
        ]);

        report($e);

        TilingChanged::broadcastForImage($this->image->fresh());
    }
}
