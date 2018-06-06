<?php

namespace App\Observers;

use App\Campaign;
use App\Models\DiceRollResult;
use App\Models\MiscModel;
use App\Models\DiceRoll;
use App\Services\DiceRollerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
