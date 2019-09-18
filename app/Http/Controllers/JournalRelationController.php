<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JournalRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'journals.relations';

    /**
     * @var string
     */
    protected $route = 'journals.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Journal $journal)
    {
        return $this->crudCreate($journal);
    }

    /**c
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Journal $journal)
    {
        return $this->crudStore($request, $journal);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal, Relation $relation)
    {
        return $this->crudEdit($journal, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Journal $journal, Relation $relation)
    {
        return $this->crudUpdate($request, $journal, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $journalRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal, Relation $relation)
    {
        return $this->crudDestroy($journal, $relation);
    }
}
