<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCharacterTraits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'character:traits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move character traits to the new system';

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
     * @return mixed
     */
    public function handle()
    {
        $traits = 0;

        $loop = ['traits', 'goals', 'fears', 'mannerisms'];

        foreach (Character::get() as $char) {
            foreach ($loop as $trait) {
                if (!empty($char->$trait)) {
                    $this->newTrait($char, $trait, $char->$trait);
                    $traits++;
                }
            }
        }

        $this->info("Created $traits traits.");
    }

    /**
     * @param Character $character
     * @param $name
     * @param $entry
     */
    protected function newTrait(Character $character, $name, $entry)
    {
        $trait = new CharacterTrait();
        $trait->charactr_id = $character->id;
        $trait->name = trans('characters.fields.' . $name);
        $trait->entry = $entry;
        $trait->section = 'personality';
        $trait->save();
    }
}
