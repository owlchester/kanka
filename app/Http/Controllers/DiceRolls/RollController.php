<?php

namespace App\Http\Controllers\DiceRolls;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use Exception;

class RollController extends Controller
{
    public function roll(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('view', $diceRoll->entity);

        try {
            DiceRollResult::create([
                'dice_roll_id' => $diceRoll->id,
                'created_by' => auth()->id(),
            ]);

            return redirect()
                ->route('entities.show', [$campaign, $diceRoll->entity])
                ->with('success', __('dice_rolls.results.success'));
        } catch (Exception) {
            return redirect()
                ->route('entities.show', [$campaign, $diceRoll->entity])
                ->with('error', __('dice_rolls.results.error'));
        }
    }

    public function destroyRoll(Campaign $campaign, DiceRoll $diceRoll, DiceRollResult $diceRollResult)
    {
        $this->authorize('delete', $diceRoll->entity);

        $diceRollResult->delete();

        return redirect()
            ->route('entities.show', [$campaign, $diceRoll->entity])
            ->with('success', __('dice_rolls.destroy.dice_roll'));
    }
}
