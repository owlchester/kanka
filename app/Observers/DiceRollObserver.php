<?php

namespace App\Observers;

use App\Models\DiceRoll;
use App\Models\MiscModel;

class DiceRollObserver extends MiscObserver
{
    public function saving(DiceRoll $model)
    {
        $model->system = 'standard';
    }
}
