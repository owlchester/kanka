<?php

namespace App\Console\Commands;

use App\Models\Map;
use App\Services\Map\ChunkingService;
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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var ChunkingService $service */
        $service = app()->make(ChunkingService::class);

        $mapID  =$this->argument('map');
        $map = Map::find($mapID);
        if (empty($map)) {
            $this->error('Unknown map ' . $mapID);
            return 0;
        }

        $this->info('Chunking map ' . $mapID);
        try {
            $service->map($map)
                ->chunk();
            $this->info('Success.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return 0;
    }
}
