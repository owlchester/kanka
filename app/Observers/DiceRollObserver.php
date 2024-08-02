<?php

namespace App\Observers;

use App\Models\DiceRoll;

class DiceRollObserver extends MiscObserver
{
    public function saving(DiceRoll $model)
    {
        $model->system = 'standard';
    }
}
