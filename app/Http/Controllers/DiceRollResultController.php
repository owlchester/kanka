<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\DiceRoll;
use App\Http\Requests\StoreDiceRoll;
use App\Models\DiceRollResult;
use App\Services\RandomDiceRollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiceRollResultController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'dice_roll_results';
    protected $route = 'dice_roll_results';

    /** @var string Model */
    protected $model = \App\Models\DiceRollResult::class;

    /** @var string Filter */
    protected $filter = DiceRollResult::class;

    /**
     * SectionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->indexActions[] = [
            'route' => route('dice_rolls.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-square"></i> ' . trans('dice_rolls.index.actions.dice')
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('browse', $this->model);

        $model = new $this->model;
        $this->filterService->make($this->view, request()->all(), $model);
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;

        $base = $model
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
            'models',
            'name',
            'model',
            'actions',
            'route',
            'filter',
            'filters',
            'filterService',
            'filteredCount',
            'unfilteredCount'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiceRoll  $diceRoll
     * @return \Illuminate\Http\Response
     */
    public function show(DiceRollResult $diceRollResult)
    {
        return redirect()->route('dice_rolls.show', $diceRollResult->diceRoll);
    }
}
