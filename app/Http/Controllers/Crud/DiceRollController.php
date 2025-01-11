<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Actions\DeprecatedDatagridActions;
use App\Datagrids\Filters\DiceRollFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreDiceRoll;
use App\Models\Campaign;
use App\Models\DiceRoll;
use App\Models\DiceRollResult;
use App\Models\EntityType;
use Exception;
use Illuminate\Support\Facades\Auth;

class DiceRollController extends CrudController
{
    protected string $view = 'dice_rolls';
    protected string $route = 'dice_rolls';
    protected string $module = 'dice_rolls';

    protected string $model = DiceRoll::class;

    protected string $filter = DiceRollFilter::class;

    protected string $datagridActions = DeprecatedDatagridActions::class;

    protected string $forceMode = 'table';

    protected function setNavActions(): CrudController
    {
        $this->addNavAction(
            route('dice_roll_results.index', $this->campaign),
            '<i class="fa-solid fa-list"></i> ' . __('dice_rolls.index.actions.results')
        );
        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/dice-rolls.html',
            '<i class="fa-solid fa-question-circle" aria-hidden="true"></i> ' . __('crud.actions.help'),
            '',
            true
        );
        return parent::setNavActions();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, StoreDiceRoll $request)
    {
        return $this->campaign($campaign)->crudStore($request, true);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudShow($diceRoll);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function edit(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudEdit($diceRoll);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function update(StoreDiceRoll $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudUpdate($request, $diceRoll);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudDestroy($diceRoll);
    }

    /**
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
            return redirect()->to($diceRoll->getLink())
                ->with('success', trans('dice_rolls.results.success'));
        } catch (Exception $e) {
            return redirect()->to($diceRoll->getLink())
                ->with('error', trans('dice_rolls.results.error'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyRoll(Campaign $campaign, DiceRoll $diceRoll, DiceRollResult $diceRollResult)
    {
        $this->authorize('delete', $diceRoll);

        $diceRollResult->delete();

        return redirect()->to($diceRoll->getLink())
            ->with('success', trans('dice_rolls.destroy.dice_roll'));
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.dice_roll'))->first();
    }
}
