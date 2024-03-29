<?php

namespace App\Observers;

use App\Models\DiceRoll;
use App\Models\MiscModel;

class DiceRollObserver extends MiscObserver
{
    public function saving(DiceRoll|MiscModel $model)
    {
        parent::saving($model);
        // @phpstan-ignore-next-line
        $model->system = 'standard';
    }
}
