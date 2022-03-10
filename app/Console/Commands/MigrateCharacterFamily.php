<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\CharacterFamily;
use Illuminate\Console\Command;

class MigrateCharacterFamily extends Command
{
    public $count = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'character:families';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate character family to families';

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
        CharacterFamily::truncate();
        Character::whereNotNull('family_id')->chunk(1000, function ($characters) {
            $this->info('1000 Chunk...');
            foreach ($characters as $character) {
                $character->families()->attach($character->family_id);
                $this->count++;
            }
        });
        $this->info('Migrated ' . $this->count . ' characters');
        return 0;
    }
}
