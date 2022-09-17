<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\JournalFilter;
use App\Facades\Datagrid;
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
    protected string $view = 'journals';
    protected string $route = 'journals';
    protected $module = 'journals';

    /** @var string Model*/
    protected $model = \App\Models\Journal::class;

    /** @var string Filter */
    protected $filter = JournalFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJournal $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        return $this->crudShow($journal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        return $this->crudEdit($journal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJournal $request, Journal $journal)
    {
        return $this->crudUpdate($request, $journal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        return $this->crudDestroy($journal);
    }

    /**
     * @param Journal $journal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function journals(Journal $journal)
    {
        $this->authCheck($journal);

        $options = ['journal' => $journal];
        $filters = [];
        if (request()->has('journal_id')) {
            $options['journal_id'] = $journal->id;
            $filters['journal_id'] = $journal->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Journal\Journal::class)
            ->route('journals.journals', $options);

        $this->rows = $journal
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['entity', 'character'])
            ->allJournals()
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($journal, 'journals');
    }
}
