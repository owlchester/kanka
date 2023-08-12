<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\JournalFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreJournal;
use App\Models\Campaign;
use App\Models\Journal;
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
    public function store(StoreJournal $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Journal $journal)
    {
        return $this->campaign($campaign)->crudShow($journal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Journal $journal)
    {
        return $this->campaign($campaign)->crudEdit($journal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJournal $request, Campaign $campaign, Journal $journal)
    {
        return $this->campaign($campaign)->crudUpdate($request, $journal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Journal $journal)
    {
        return $this->campaign($campaign)->crudDestroy($journal);
    }

    /**
     * @param Journal $journal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function journals(Campaign $campaign, Journal $journal)
    {
        $this->authCheck($journal);

        $options = ['campaign' => $campaign, 'journal' => $journal];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $journal->id;
            $filters['journal_id'] = $journal->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Journal\Journal::class)
            ->route('journals.journals', $options);

        $this->rows = $journal
            ->allJournals()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with(['entity', 'character'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->menuView($journal, 'journals');
    }
}
