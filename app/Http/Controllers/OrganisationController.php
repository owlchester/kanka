<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\OrganisationFilter;
use App\Datagrids\Sorters\OrganisationCharacterSorter;
use App\Datagrids\Sorters\OrganisationOrganisationSorter;
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

    /** @var string */
    protected $model = \App\Models\Organisation::class;

    /** @var string Filter */
    protected $filter = OrganisationFilter::class;

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
        return $this
            ->datagridSorter(OrganisationOrganisationSorter::class)
            ->menuView($organisation, 'organisations');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function members(Organisation $organisation)
    {
        return $this->datagridSorter(OrganisationCharacterSorter::class)
            ->menuView($organisation, 'members');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allMembers(Organisation $organisation)
    {
        return $this
            ->datagridSorter(OrganisationCharacterSorter::class)
            ->menuView($organisation, 'all_members');
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
