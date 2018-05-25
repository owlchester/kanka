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

class DiceRollController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'dice_rolls';
    protected $route = 'dice_rolls';

    /**
     * @var string
     */
    protected $model = \App\Models\DiceRoll::class;

    /**
     * SectionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->filters = [
            'name',
            [
                'field' => 'character_id',
                'label' => trans('crud.fields.character'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  trans('crud.placeholders.character'),
                'model' => Character::class,
            ],
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

        $result = DiceRollResult::create([
            'dice_roll_id' => $diceRoll->id,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('dice_rolls.show', $diceRoll)
            ->with('success', trans('dice_rolls.results.success'));
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
