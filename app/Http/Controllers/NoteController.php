<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNote;
use App\Note;
use Illuminate\Support\Facades\Session;

class NoteController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'notes';
    protected $route = 'notes';

    /**
     * @var string
     */
    protected $model = \App\Note::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNote $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return $this->crudShow($note);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return $this->crudEdit($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNote $request, Note $note)
    {
        return $this->crudUpdate($request, $note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        return $this->crudDestroy($note);
    }
}
