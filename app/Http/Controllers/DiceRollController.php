<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\DeprecatedDatagridActions;
use App\Datagrids\Filters\DiceRollFilter;
use App\Http\Requests\StoreDiceRoll;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
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

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addNavAction(
            route('dice_roll_results.index'),
            '<i class="fa-solid fa-list"></i> ' . __('dice_rolls.index.actions.results')
        );
        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/dice-rolls.html',
            '<i class="fa-solid fa-question-circle"></i> ' . __('crud.actions.help'),
            'default',
            true
        );
    }

    /**
     * @param StoreDiceRoll $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreDiceRoll $request)
    {
        return $this->crudStore($request, true);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(DiceRoll $diceRoll)
    {
        return $this->crudShow($diceRoll);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function edit(DiceRoll $diceRoll)
    {
        return $this->crudEdit($diceRoll);
    }

    /**
     * @param StoreDiceRoll $request
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(StoreDiceRoll $request, DiceRoll $diceRoll)
    {
        return $this->crudUpdate($request, $diceRoll);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DiceRoll $diceRoll)
    {
        return $this->crudDestroy($diceRoll);
    }

    /**
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function roll(DiceRoll $diceRoll)
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
    public function destroyRoll(DiceRoll $diceRoll, DiceRollResult $diceRollResult)
    {
        $this->authorize('delete', $diceRoll);

        $diceRollResult->delete();

        return redirect()->route('dice_rolls.show', $diceRoll)
            ->with('success', trans('dice_rolls.destroy.dice_roll'));
    }
}
