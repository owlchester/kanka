<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\CrudController;
use App\Models\Campaign;
use App\Models\DiceRollResult;
use App\Renderers\DatagridRenderer;
use Illuminate\Http\Request;

class DiceRollResultController extends CrudController
{
    protected string $view = 'dice_roll_results';
    protected string $route = 'dice_roll_results';

    protected string $model = DiceRollResult::class;

    protected string $filter = DiceRollResult::class;

    protected string $forceMode = 'table';

    protected function setNavActions(): CrudController
    {
        $this->addNavAction(
            route('dice_rolls.index', $this->campaign),
            '<i class="fa-solid fa-square" aria-hidden="true"></i> ' . __('entities.dice_rolls')
        );
        return parent::setNavActions();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Campaign $campaign)
    {
        //$this->authorize('browse', $this->model);
        $this->campaign($campaign);

        $model = new $this->model();
        $this->filterService->request($request)
            ->model($model)
            ->make($this->view);
        $name = $this->view;
        $langKey = $name;
        $this->setNavActions();
        $actions = $this->navActions;
        $filterService = $this->filterService;

        $base = $model
            ->search(request()->get('search'))
            ->with([
                'diceRoll', 'diceRoll.entity', 'diceRoll.entity.image',
                'user', 'diceRoll.character', 'diceRoll.character.entity'
            ])
            ->has('diceRoll')
            ->order($this->filterService->order())
        ;
        $unfilteredCount = $base->count();
        $base = $base->filter($this->filterService->filters());
        $filteredCount =  $base->count();
        $route = 'dice_roll_results';
        $mode = 'table';
        $forceMode = $this->forceMode;

        $models = $base->paginate();

        $datagrid = new DatagridRenderer();
        $datagrid
            ->campaign($campaign)
            ->service($filterService)
            ->models($models);

        return view('cruds.index', compact(
            'campaign',
            'models',
            'name',
            'actions',
            'route',
            'filteredCount',
            'unfilteredCount',
            'langKey',
            'mode',
            'forceMode',
            'datagrid',
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, DiceRollResult $diceRollResult)
    {
        return redirect()->to($diceRollResult->diceRoll->getLink());
    }

    public function titleKey(): string
    {
        return __('dice_roll_results.index.title');
    }
}
