<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Relation;
use App\Http\Requests\StoreRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionRelationController extends CrudRelationController
{
    /**
     * @var string
     */
    protected $view = 'sections.relations';

    /**
     * @var string
     */
    protected $route = 'sections.relations';

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Section $section)
    {
        return $this->crudCreate($section);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelation $request, Section $section)
    {
        return $this->crudStore($request, $section);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section, Relation $relation)
    {
        return $this->crudEdit($section, $relation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelation $request, Section $section, Relation $relation)
    {
        return $this->crudUpdate($request, $section, $relation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Relation  $sectionRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section, Relation $relation)
    {
        return $this->crudDestroy($section, $relation);
    }
}
