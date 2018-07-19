<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\MiscModel;

class DiceRollObserver extends MiscObserver
{
    /**
     * @param Campaign $campaign
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);
        $model->system = 'standard';
    }
}
