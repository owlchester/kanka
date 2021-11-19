<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateEntityTypeID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entities:type_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate entities to the type_id field';

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
        $types = [
            1 => 'character',
            2 => 'family',
            3 => 'location',
            4 => 'organisation',
            5 => 'item',
            6 => 'note',
            7 => 'event',
            8 => 'calendar',
            9 => 'race',
            10 => 'quest',
            11 => 'journal',
            12 => 'tag',
            13 => 'dice_roll',
            14 => 'conversation',
            15 => 'attribute_template',
            16 => 'ability',
            17 => 'map',
            18 => 'timeline',
            19 => 'menu_links',
        ];

        // The pain begins
        foreach ($types as $id => $type) {
            $this->info($type);
            $count = DB::update("UPDATE entities SET type_id = '" . $id . "' WHERE type = '" . $type . "'");
            $this->info($count);

        }

        return 0;
    }
}
