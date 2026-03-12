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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DiceRollController extends CrudController
{
    protected string $view = 'dice_rolls';

    protected string $route = 'dice_rolls';

    protected string $module = 'dice_rolls';

    protected string $model = DiceRoll::class;

    protected string $filter = DiceRollFilter::class;

    protected string $datagridActions = DeprecatedDatagridActions::class;

    protected string $forceMode = 'table';

    /**
     * @return JsonResponse|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function store(Campaign $campaign, StoreDiceRoll $request)
    {
        return $this->campaign($campaign)->crudStore($request, true);
    }

    /**
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     */
    public function show(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudShow($diceRoll);
    }

    /**
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     * @throws BindingResolutionException
     */
    public function edit(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudEdit($diceRoll);
    }

    /**
     * @return JsonResponse|RedirectResponse
     *
     * @throws AuthorizationException
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(StoreDiceRoll $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudUpdate($request, $diceRoll);
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, DiceRoll $diceRoll)
    {
        return $this->campaign($campaign)->crudDestroy($diceRoll);
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function roll(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('view', $diceRoll->entity);

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
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroyRoll(Campaign $campaign, DiceRoll $diceRoll, DiceRollResult $diceRollResult)
    {
        $this->authorize('delete', $diceRoll->entity);

        $diceRollResult->delete();

        return redirect()->to($diceRoll->getLink())
            ->with('success', trans('dice_rolls.destroy.dice_roll'));
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.dice_roll'))->first();
    }
}
