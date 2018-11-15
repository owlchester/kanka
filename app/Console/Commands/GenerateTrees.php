<?php

namespace App\Console\Commands;

use App\Models\AttributeTemplate;
use App\Models\Location;
use App\Models\MapPoint;
use App\Models\Organisation;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateTrees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the trees';

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
//        Location::fixTree();
//        Organisation::fixTree();
//        Tag::fixTree();
        AttributeTemplate::fixTree();
        $this->info("Fixed tree.");
    }
}
