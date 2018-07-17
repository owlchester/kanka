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
    }

    /**
     * @param MiscModel $model
     */
    protected function saveTraits(MiscModel $character, $trait = 'personality')
    {
        $existing = [];
        foreach ($character->characterTraits()->{$trait}()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitCount = $traitOrder = 0;
        $traitNames = request()->post($trait . '_name', []);
        $traitEntry = request()->post($trait . '_entry', []);

        foreach ($traitNames as $id => $name) {
            if (empty($name)) {
                continue;
            }

            if (!empty($existing[$id])) {
                $model = $existing[$id];
                unset($existing[$id]);
            } else {
                $model = new CharacterTrait();
                $model->character_id = $character->id;
                $model->section = $trait;
            }
            $model->name = $name;
            $model->entry = $traitEntry[$id];
            $model->default_order = $traitOrder;
            $model->save();
            $traitCount++;
            $traitOrder++;
        }

        foreach ($existing as $id => $model) {
            $model->delete();
        }
    }
}
