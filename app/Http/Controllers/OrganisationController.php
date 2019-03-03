<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganisation;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;

class OrganisationController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'organisations';
    protected $route = 'organisations';

    /**
     * @var string
     */
    protected $model = \App\Models\Organisation::class;

    /**
     * OrganisationController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
            'type',
            [
                'field' => 'location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ],
            [
                'field' => 'organisation_id',
                'label' => trans('crud.fields.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find'),
                'placeholder' =>  trans('crud.placeholders.organisation'),
                'model' => Organisation::class,
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
    public function store(StoreOrganisation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return $this->crudShow($organisation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation)
    {
        return $this->crudEdit($organisation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisation $request, Organisation $organisation)
    {
        return $this->crudUpdate($request, $organisation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        return $this->crudDestroy($organisation);
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quests(Organisation $organisation)
    {
        return $this->menuView($organisation, 'quests');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Organisation $organisation)
    {
        return $this->menuView($organisation, 'organisations');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function members(Organisation $organisation)
    {
        return $this->menuView($organisation, 'members');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allMembers(Organisation $organisation)
    {
        return $this->menuView($organisation, 'all_members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Organisation $organisation)
    {
        return $this->menuView($organisation, 'map-points', true);
    }
}
