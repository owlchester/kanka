<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\JournalFilter;
use App\Models\Journal;
use App\Http\Requests\StoreJournal;
use App\Traits\TreeControllerTrait;

class JournalController extends CrudController
{
    /**
     * Tree / Nested Mode
     */
    use TreeControllerTrait;
    protected $treeControllerParentKey = 'journal_id';

    /**
     * @var string
     */
    protected $view = 'journals';
    protected $route = 'journals';

    /** @var string Model*/
    protected $model = \App\Models\Journal::class;

    /** @var string Filter */
    protected $filter = JournalFilter::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJournal $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        return $this->crudShow($journal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        return $this->crudEdit($journal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreJournal $request, Journal $journal)
    {
        return $this->crudUpdate($request, $journal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        return $this->crudDestroy($journal);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Journal $journal)
    {
        return $this->menuView($journal, 'map-points', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function journals(Journal $journal)
    {
        return $this->menuView($journal, 'journals');
    }
}
