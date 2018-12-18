<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNote;
use App\Models\Note;
use App\Models\Tag;
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
    protected $model = \App\Models\Note::class;

    /**
     * NoteController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
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
}
