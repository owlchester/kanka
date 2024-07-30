<?php

namespace App\Observers;

use App\Models\DiceRollResult;
use App\Services\DiceRollerService;
use Illuminate\Support\Facades\Auth;

class DiceRollResultObserver
{
    protected DiceRollerService $diceRollerService;

    public function __construct(DiceRollerService $diceRollerService)
    {
        $this->diceRollerService = $diceRollerService;
    }

    /**
     */
    public function saving(DiceRollResult $model)
    {
        $model->results = $this->diceRollerService->roll($model->diceRoll);
    }
}
