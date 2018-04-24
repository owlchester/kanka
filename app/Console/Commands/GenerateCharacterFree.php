<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\EntityNote;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCharacterFree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'character:free';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move character free to a note';

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
        $notes = 0;

        foreach (Character::whereNotNull('free')->get() as $character) {
            // Create a new note
            $note = new EntityNote();
            $note->entity_id = $character->entity->id;
            $note->name = 'Free Text';
            $note->entry = $character->free;
            $note->is_private = !$character->is_personality_visible;
            $note->save();

            $character->free = null;
            $character->save();

            $notes++;
        }

        $this->info("Created $notes notes.");
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
