<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateLocationTree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:tree';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the location tree';

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
     */
    public function handle()
    {
        Location::fixTree();
        $this->info("Fixed tree.");
    }
}
