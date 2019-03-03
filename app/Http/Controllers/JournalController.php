<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Journal;
use App\Http\Requests\StoreJournal;
use App\Models\Location;
use App\Models\Tag;
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
            [
                'field' => 'location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ],
            [
                'field' => 'tag_id',
                'label' => trans('crud.fields.tag'),
                'type' => 'select2',
                'route' => route('tags.find'),
                'placeholder' =>  trans('crud.placeholders.tag'),
                'model' => Tag::class,
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
}
