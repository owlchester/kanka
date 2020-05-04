<?php

namespace App\Console\Commands;

use App\Models\Ability;
use App\Models\Family;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use Illuminate\Console\Command;

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
     * Execute the console command.
     */
    public function handle()
    {
        Race::fixTree();
        Location::fixTree();
        Organisation::fixTree();
        Family::fixTree();
        Tag::fixTree();
        Ability::fixTree();
        Quest::fixTree();
        $this->info("Fixed tree.");
    }
}
