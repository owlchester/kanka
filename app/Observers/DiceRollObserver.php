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
     * @param Campaign $campaign
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        $model->created_by = Auth::user()->id;

        $model->system = 'standard';
        $model->results = $this->diceRollerService->roll($model->parameters);
    }
}
