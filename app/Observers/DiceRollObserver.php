<?php

namespace App\Observers;

use App\Models\DiceRoll;

class DiceRollObserver
{
    public function saving(DiceRoll $model)
    {
        $model->system = "standard";
    }
}
