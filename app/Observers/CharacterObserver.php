<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class CharacterObserver extends MiscObserver
{
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Handle character traits
        $traits = [];
        $existing = [];
        foreach ($model->characterTraits()->personality()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitCount = 0;
        $traitNames = request()->post('personality_name');
        $traitEntry = request()->post('personality_entry');
        foreach ($traitNames as $id => $name) {
            if (empty($name)) {
                continue;
            }

            if (!empty($existing[$id])) {
                $trait = $existing[$id];
                unset($existing[$id]);
            } else {
                $trait = new CharacterTrait();
                $trait->character_id = $model->id;
                $trait->section = 'personality';
            }
            $trait->name = $name;
            $trait->entry = $traitEntry[$id];
            $trait->save();
            $traitCount++;
        }

        foreach ($existing as $id => $trait) {
            $trait->delete();
        }
    }
    /**
     * @param Character $character
     */
    public function deleting(MiscModel $character)
    {
        parent::deleting($character);

        foreach ($character->items as $item) {
            $item->character_id = null;
            $item->save();
        }

        // Delete members
        $character->organisations()->delete();
    }
}
