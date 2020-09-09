<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\NoteFilter;
use App\Http\Requests\StoreNote;
use App\Models\Note;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;
use Illuminate\Support\Facades\Session;

class NoteController extends CrudController
{
    /**
     * Tree / Nested Mode
     */
    use TreeControllerTrait;
    protected $treeControllerParentKey = 'note_id';

    /**
     * @var string
     */
    protected $view = 'notes';
    protected $route = 'notes';

    /** @var string */
    protected $model = \App\Models\Note::class;

    /** @var string Filter */
    protected $filter = NoteFilter::class;

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
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return $this->crudShow($note);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note $note
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
     * @param  \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNote $request, Note $note)
    {
        return $this->crudUpdate($request, $note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        return $this->crudDestroy($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Note $note)
    {
        return $this->menuView($note, 'map-points', true);
    }
}
