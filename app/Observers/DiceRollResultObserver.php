<?php

namespace App\Observers;

use App\Models\DiceRollResult;
use App\Services\DiceRollerService;
use Illuminate\Support\Facades\Auth;

class DiceRollResultObserver
{
    /**
     * @var DiceRollerService
     */
    protected $diceRollerService;

    /**
     * DiceRollObserver constructor.
     * @param DiceRollerService $diceRollerService
     */
    public function __construct(DiceRollerService $diceRollerService)
    {
        $this->diceRollerService = $diceRollerService;
    }

    /**
     * @param DiceRollResult $model
     */
    public function saving(DiceRollResult $model)
    {
        $model->created_by = Auth::user()->id;
        $model->results = $this->diceRollerService->roll($model->diceRoll);
    }
}
