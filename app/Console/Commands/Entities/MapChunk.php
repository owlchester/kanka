<?php

namespace App\Console\Commands\Entities;

use App\Jobs\ChunkMapJob;
use App\Models\Map;
use Illuminate\Console\Command;

class MapChunk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:chunk {map : The map ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chunks a map\'s image into tiles.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $mapID = (int) $this->argument('map');
        $map = Map::find($mapID);
        if (empty($map)) {
            $this->error('Unknown map #' . $mapID);

            return 0;
        }

        $this->dispatch($mapID);
        $this->info('ChunkMapJob queues for map #' . $mapID);

        return 0;
    }

    /**
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    protected function dispatch(int $mapID)
    {
        return ChunkMapJob::dispatch($mapID);
    }
}
