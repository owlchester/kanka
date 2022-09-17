<?php

namespace App\Observers;

use App\Models\DiceRoll;
use App\Models\MiscModel;

class DiceRollObserver extends MiscObserver
{
    /**
     * @param DiceRoll|MiscModel $model
     */
    public function saving(DiceRoll|MiscModel $model)
    {
        parent::saving($model);
        $model->system = 'standard';
    }
}
