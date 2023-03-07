<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\NoDatagridActions;
use App\Models\Campaign;
use App\Models\DiceRollResult;
use Illuminate\Http\Request;

class DiceRollResultController extends CrudController
{
    /**
     * @var string
     */
    protected string $view = 'dice_roll_results';
    protected string $route = 'dice_roll_results';

    /** @var string Model */
    protected $model = \App\Models\DiceRollResult::class;

    /** @var string Filter */
    protected $filter = DiceRollResult::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Campaign $campaign)
    {
        //$this->authorize('browse', $this->model);
        $this->addNavAction(
            route('dice_rolls.index', $campaign),
            '<i class="fa-solid fa-square"></i> ' . __('dice_rolls.index.actions.dice')
        );

        $model = new $this->model();
        $this->filterService->make($this->view, request()->all(), $model);
        $name = $this->view;
        $langKey = $name;
        $actions = $this->navActions;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $datagridActions = new NoDatagridActions();

        $base = $model
            ->with(['user', 'diceRoll', 'diceRoll.character'])
            ->search(request()->get('search'))
            ->order($this->filterService->order())
        ;
        $unfilteredCount = $base->count();
        $base = $base->filter($this->filterService->filters());
        $filteredCount =  $base->count();
        $filter = false; //new $this->filter;
        $route = 'dice_roll_results';

        $models = $base->paginate();
        return view('cruds.index', compact(
            'campaign',
            'models',
            'name',
            'model',
            'actions',
            'route',
            'filter',
            'filters',
            'filterService',
            'filteredCount',
            'unfilteredCount',
            'langKey',
            'datagridActions'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, DiceRollResult $diceRollResult)
    {
        return redirect()->to($diceRollResult->diceRoll->getLink());
    }
}
