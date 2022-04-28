<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\OrganisationFilter;
use App\Datagrids\Sorters\OrganisationCharacterSorter;
use App\Datagrids\Sorters\OrganisationOrganisationSorter;
use App\Facades\Datagrid;
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
    protected $module = 'organisations';

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
    public function organisations(Organisation $organisation)
    {
        $this->authCheck($organisation);

        Datagrid::layout(\App\Renderers\Layouts\Organisation\Organisation::class)
            ->route('organisations.organisations', [$organisation]);

        $this->rows = $organisation
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'organisation', 'organisation.entity'])
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($organisation, 'organisations');
    }

    /**
     * @param Organisation $organisation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function members(Organisation $organisation)
    {
        $this->authCheck($organisation);

        $options = ['tag' => $organisation];
        $base = 'members';
        if (request()->has('all')) {
            $options['all'] = true;
            $base = 'allMembers';
        }
        Datagrid::layout(\App\Renderers\Layouts\Organisation\Member::class)
            ->route('organisations.members', $options);

        $this->rows = $organisation
            ->{$base}()
            ->with(['organisation', 'organisation.entity'])
            ->has('character')
            //->sort(request()->only(['o', 'k']))
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
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
}
