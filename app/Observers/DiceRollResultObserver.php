<?php

namespace App\Observers;

use App\Models\DiceRollResult;
use App\Services\DiceRollerService;

class DiceRollResultObserver
{
    public function __construct(protected DiceRollerService $diceRollerService) {}

    public function creating(DiceRollResult $model)
    {
        if (empty($model->results)) {
            $model->results = $this->diceRollerService->roll($model->diceRoll);
        }
    }
}
