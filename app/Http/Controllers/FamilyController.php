<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreLocation;
use App\Models\Family;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'families';
    protected $route = 'families';

    /**
     * @var string
     */
    protected $model = \App\Models\Family::class;

    /**
     * FamilyController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
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
    public function store(StoreFamily $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        return $this->crudShow($family);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family)
    {
        return $this->crudEdit($family);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family $family
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFamily $request, Family $family)
    {
        return $this->crudUpdate($request, $family);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        return $this->crudDestroy($family);
    }
}
