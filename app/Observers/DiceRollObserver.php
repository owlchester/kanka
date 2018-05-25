<?php

namespace App\Observers;

use App\Campaign;
use App\Models\MiscModel;
use App\Models\DiceRoll;
use App\Services\DiceRollerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
