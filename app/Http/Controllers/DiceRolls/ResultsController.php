<?php

namespace App\Http\Controllers\DiceRolls;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\DiceRollResult;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $models = DiceRollResult::with([
            'diceRoll',
            'diceRoll.entity',
            'diceRoll.entity.image',
            'user',
            'diceRoll.character',
            'diceRoll.character.entity'
        ])
            ->orderByDesc('updated_at')
            ->has('diceRoll')
            ->has('diceRoll.entity')
            ->paginate()
        ;

        return view('dice_rolls.results')
            ->with('campaign', $campaign)
            ->with('models', $models)
        ;
    }
}
