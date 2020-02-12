<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\DiceRollFilter;
use App\Models\Character;
use App\Models\DiceRoll;
use App\Http\Requests\StoreDiceRoll;
use App\Models\DiceRollResult;
use App\Models\Tag;
use App\Services\RandomDiceRollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DiceRollController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'dice_rolls';
    protected $route = 'dice_rolls';

    /** @var string Model */
    protected $model = \App\Models\DiceRoll::class;

    /** @var string Filter */
    protected $filter = DiceRollFilter::class;

    /**
     * SectionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->indexActions[] = [
            'route' => route('dice_roll_results.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans('dice_rolls.index.actions.results')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiceRoll $request)
    {
        return $this->crudStore($request, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiceRoll  $diceRoll
     * @return \Illuminate\Http\Response
     */
    public function show(DiceRoll $diceRoll)
    {
        return $this->crudShow($diceRoll);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiceRoll  $diceRoll
     * @return \Illuminate\Http\Response
     */
    public function edit(DiceRoll $diceRoll)
    {
        return $this->crudEdit($diceRoll);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiceRoll  $diceRoll
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDiceRoll $request, DiceRoll $diceRoll)
    {
        return $this->crudUpdate($request, $diceRoll);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiceRoll  $diceRoll
     * @return \Illuminate\Http\Response
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function rolls()
    {
        $actions = [[
            'route' => route('dice_rolls.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-block"></i> ' . trans('dice_rolls.index.actions.dice')
        ]];

        $filters = [
            [
                'field' => 'dice_roll_id',
                'label' => trans('crud.fields.dice_roll'),
                'type' => 'select2',
                'route' => route('dice_rolls.find'),
                'placeholder' =>  trans('crud.placeholders.dice_roll'),
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

        $this->authorize('browse', $this->model);

        // Add the is_private filter only for admins.
//        if (Auth::user()->isAdmin()) {
//            $this->filters[] = 'is_private';
//        }

        $model = new DiceRollResult();
        $this->filterService->prepare('dice_rolls-rolls', request()->all(), $model->getFilterableColumns());
        $name = $this->view . '.rolls';
        $filterService = $this->filterService;

        $models = $model
            ->search(request()->get('search'))
            ->filter($this->filterService->filters())
            ->order($this->filterService->order())
            ->paginate();
        return view('cruds.index', compact('models', 'name', 'model', 'actions', 'filters', 'filterService'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(DiceRoll $diceRoll)
    {
        return $this->menuView($diceRoll, 'map-points', true);
    }
}
