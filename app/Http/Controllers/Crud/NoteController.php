<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\NoteFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreNote;
use App\Models\Campaign;
use App\Models\Note;
use App\Traits\TreeControllerTrait;

class NoteController extends CrudController
{
    use TreeControllerTrait;

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
    public function store(StoreNote $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     */
    public function show(Campaign $campaign, Note $note)
    {
        return $this->campaign($campaign)->crudShow($note);
    }

    /**
     */
    public function edit(Campaign $campaign, Note $note)
    {
        return $this->campaign($campaign)->crudEdit($note);
    }

    /**
     */
    public function update(StoreNote $request, Campaign $campaign, Note $note)
    {
        return $this->campaign($campaign)->crudUpdate($request, $note);
    }

    /**
     */
    public function destroy(Campaign $campaign, Note $note)
    {
        return $this->campaign($campaign)->crudDestroy($note);
    }
}
