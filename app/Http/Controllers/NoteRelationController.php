<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NoteRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'notes.relations';

    /**
     * @var string
     */
    protected $route = 'notes.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Note $note)
    {
        return $this->crudCreate($note);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Note $note)
    {
        return $this->crudStore($request, $note);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note, Relation $relation)
    {
        return $this->crudEdit($note, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Note $note, Relation $relation)
    {
        return $this->crudUpdate($request, $note, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $noteRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note, Relation $relation)
    {
        return $this->crudDestroy($note, $relation);
    }
}
