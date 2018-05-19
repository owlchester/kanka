<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Journal;
use App\Http\Requests\StoreJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JournalController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'journals';
    protected $route = 'journals';

    /**
     * @var string
     */
    protected $model = \App\Models\Journal::class;

    /**
     * JournalController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
            'date',
            [
                'field' => 'character_id',
                'label' => trans('journals.fields.author'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  trans('crud.placeholders.character'),
                'model' => Character::class,
            ],
        ];
    }

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
}
