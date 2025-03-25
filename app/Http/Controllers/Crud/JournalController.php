<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\JournalFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreJournal;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Journal;

class JournalController extends CrudController
{
    protected string $view = 'journals';

    protected string $route = 'journals';

    protected string $module = 'journals';

    protected string $model = Journal::class;

    protected string $filter = JournalFilter::class;

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

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.journal'))->first();
    }
}
