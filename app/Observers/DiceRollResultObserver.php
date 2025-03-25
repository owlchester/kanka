<?php

namespace App\Observers;

use App\Models\DiceRollResult;
use App\Services\DiceRollerService;

class DiceRollResultObserver
{
    public function __construct(protected DiceRollerService $diceRollerService) {}

    public function saving(DiceRollResult $model)
    {
        $model->results = $this->diceRollerService->roll($model->diceRoll);
    }
}
