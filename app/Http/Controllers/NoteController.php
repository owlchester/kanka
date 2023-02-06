<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\NoteFilter;
use App\Http\Requests\StoreNote;
use App\Models\Note;
use App\Traits\TreeControllerTrait;

class NoteController extends CrudController
{
    use TreeControllerTrait;

    protected $treeControllerParentKey = 'note_id';

    /**
     * @var string
     */
    protected string $view = 'notes';
    protected string $route = 'notes';
    protected $module = 'notes';

    /** @var string */
    protected $model = \App\Models\Note::class;

    /** @var string Filter */
    protected $filter = NoteFilter::class;

    /**
     * @param StoreNote $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNote $request)
    {
        return $this->crudStore($request);
    }

    /**
     */
    public function show(Note $note)
    {
        return $this->crudShow($note);
    }

    /**
     */
    public function edit(Note $note)
    {
        return $this->crudEdit($note);
    }

    /**
     */
    public function update(StoreNote $request, Note $note)
    {
        return $this->crudUpdate($request, $note);
    }

    /**
     */
    public function destroy(Note $note)
    {
        return $this->crudDestroy($note);
    }
}
