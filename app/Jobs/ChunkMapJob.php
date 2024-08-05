<?php

namespace App\Jobs;

use App\Models\Map;
use App\Services\Maps\ChunkingService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ChunkMapJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 1;

    protected $mapID;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $mapID)
    {
        $this->mapID = $mapID;
        $this->onConnection('heavy');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var ChunkingService $service */
        $service = app()->make(ChunkingService::class);

        /** @var ?Map $map */
        $map = Map::find($this->mapID);
        if (empty($map)) {
            Log::error('Chunking map: unknown map #' . $this->mapID);
            return;
        }

        $now = Carbon::now();
        Log::info('Chunking map #' . $this->mapID);
        try {
            $service
                ->map($map)
                ->chunk();

            $elapsed = Carbon::now()->diffInMinutes($now);
            Log::info('Chunked map #' . $this->mapID . ' in ' . $elapsed . ' minutes.');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        /** @var ?Map $map */
        $map = Map::find($this->mapID);
        if (empty($map)) {
            Log::error('No map #' . $this->mapID);
            return;
        }

        if ($map->chunkingError()) {
            Log::error('Already error #' . $this->mapID);
            return;
        }
        $map->chunking_status = Map::CHUNKING_ERROR;
        $map->saveQuietly();

        Log::error('Saved error for #' . $this->mapID);

        throw $exception;
    }
}
