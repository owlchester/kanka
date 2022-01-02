<?php

namespace App\Console\Commands;

use App\Models\Character;
use Illuminate\Console\Command;

class MigrateCharacterRace extends Command
{
    public $count = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'character:races';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate character race to races';

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
        Character::whereNotNull('race_id')->chunk(1000, function ($characters) {
            foreach ($characters as $character) {
                $character->races()->attach($character->race_id);
                $this->count++;
            }
        });
        $this->info('Migrated ' . $this->count . ' characters');
        return 0;
    }
}
