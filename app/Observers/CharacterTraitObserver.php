<?php


namespace App\Observers;


use App\Facades\Mentions;
use App\Models\CharacterTrait;

class CharacterTraitObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param CharacterTrait $model
     */
    public function saving(CharacterTrait $model)
    {

        $model->entry = $this->purify(Mentions::codify($model->entry));
    }
}
