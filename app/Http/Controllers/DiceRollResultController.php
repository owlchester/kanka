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

    /**
     * @var string
     */
    protected $model = \App\Models\DiceRollResult::class;

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

        $this->filters = [
            [
                'field' => 'dice_roll_id',
                'label' => trans('crud.fields.dice_roll'),
                'type' => 'select2',
                'route' => route('dice_rolls.find'),
                'placeholder' =>  trans('dice_rolls.placeholders.dice_roll'),
                'model' => DiceRoll::class,
            ],
            [
                'field' => 'diceRoll-character_id',
                'label' => trans('crud.fields.character'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  trans('crud.placeholders.character'),
                'model' => Character::class,
            ],
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

        // Add the is_private filter only for admins.
        if (Auth::check() && Auth::user()->isAdmin()) {
            //$this->filters[] = 'is_private';
        }

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

        $models = $base->paginate();
        return view('cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
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
