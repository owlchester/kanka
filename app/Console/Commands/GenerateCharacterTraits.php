<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $moral = $appearance = 0;

        $loop = ['traits', 'goals', 'fears', 'mannerisms'];
        $physicals = ['height', 'weight', 'eye_colour', 'hair', 'skin', 'languages'];

        foreach (Character::with('campaign')->get() as $char) {
            foreach ($loop as $trait) {
                if (!empty($char->$trait)) {
                    $this->newTrait($char, $trait, $char->$trait);
                    $moral++;
                }
            }

            foreach ($physicals as $physical) {
                if (!empty($char->$physical)) {
                    $this->newTrait($char, $physical, $char->$physical, 'appearance');
                    $appearance++;
                }
            }
        }

        $this->info("Created $moral moral and $appearance physical traits.");
    }

    /**
     * Create the new character trait
     * @param Character $character
     * @param $name
     * @param $entry
     * @param string $section
     */
    protected function newTrait(Character $character, $name, $entry, $section = 'personality')
    {
        // Not following a standard
        if ($name == 'eye_colour') {
            $name = 'eye';
        }

        $trait = new CharacterTrait();
        $trait->character_id = $character->id;
        $trait->name = trans('characters.fields.' . $name, [], $character->campaign->locale);
        $trait->entry = $entry;
        $trait->section = $section;
        $trait->save();
    }
}
