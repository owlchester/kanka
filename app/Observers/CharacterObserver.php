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
    /**
     * After a character model has been saved to the db
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);

        // Handle character traits
        if (request()->has('personality_name')) {
            $this->saveTraits($model, 'personality');
        }
        if (request()->has('appearance_name')) {
            $this->saveTraits($model, 'appearance');
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

    /**
     * @param MiscModel $model
     */
    protected function saveTraits(MiscModel $model, $trait = 'personality')
    {
        $traits = [];
        $existing = [];
        foreach ($model->characterTraits()->{$trait}()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitCount = 0;
        $traitNames = request()->post($trait . '_name', []);
        $traitEntry = request()->post($trait . '_entry', []);
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
                $trait->section = $trait;
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
}
