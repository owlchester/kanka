<?php

namespace App\Http\Controllers;

use App\Models\DiceRoll;
use App\Models\Section;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiceRollRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'dice_rolls.relations';

    /**
     * @var string
     */
    protected $route = 'dice_rolls.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DiceRoll $diceRoll)
    {
        return $this->crudCreate($diceRoll);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, DiceRoll $diceRoll)
    {
        return $this->crudStore($request, $diceRoll);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(DiceRoll $diceRoll, Relation $relation)
    {
        return $this->crudEdit($diceRoll, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, DiceRoll $diceRoll, Relation $relation)
    {
        return $this->crudUpdate($request, $diceRoll, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $sectionRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiceRoll $diceRoll, Relation $relation)
    {
        return $this->crudDestroy($diceRoll, $relation);
    }
}
