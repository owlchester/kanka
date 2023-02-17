<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\DeprecatedDatagridActions;
use App\Datagrids\Filters\DiceRollFilter;
use App\Http\Requests\StoreDiceRoll;
use App\Models\Campaign;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiceRollController extends CrudController
{
    /**
     * @var string
     */
    protected string $view = 'dice_rolls';
    protected string $route = 'dice_rolls';
    protected $module = 'dice_rolls';

    /** @var string Model */
    protected $model = \App\Models\DiceRoll::class;

    /** @var string Filter */
    protected $filter = DiceRollFilter::class;

    /** @var string  */
    protected $datagridActions = DeprecatedDatagridActions::class;

    public function index(Request $request, Campaign $campaign)
    {
        $this->addNavAction(
            route('dice_roll_results.index', [$campaign]),
            '<i class="fa-solid fa-list"></i> ' . __('dice_rolls.index.actions.results')
        );
        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/dice-rolls.html',
            '<i class="fa-solid fa-question-circle"></i> ' . __('crud.actions.help'),
            'default',
            true
        );

        return $this->campaign($campaign)->crudIndex($request);
    }
    public function store(StoreDiceRoll $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request, true);
    }

    public function show(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudShow($diceRoll);
    }

    public function edit(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudEdit($diceRoll);
    }

    public function update(StoreDiceRoll $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudUpdate($request, $diceRoll);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudDestroy($diceRoll);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function roll(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('roll', $diceRoll);

        try {
            $result = DiceRollResult::create([
                'dice_roll_id' => $diceRoll->id,
                'created_by' => Auth::user()->id,
            ]);
            return redirect()->route('dice_rolls.show', $diceRoll)
                ->with('success', trans('dice_rolls.results.success'));
        } catch (\Exception $e) {
            return redirect()->route('dice_rolls.show', $diceRoll)
                ->with('error', trans('dice_rolls.results.error'));
        }
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyRoll(Campaign $campaign, DiceRoll $diceRoll, DiceRollResult $diceRollResult)
    {
        $this->authorize('delete', $diceRoll);

        $diceRollResult->delete();

        return redirect()->route('dice_rolls.show', $diceRoll)
            ->with('success', trans('dice_rolls.destroy.dice_roll'));
    }
}
