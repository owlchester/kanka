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
    protected string $view = 'organisations';
    protected string $route = 'organisations';
    protected $module = 'organisations';

    /** @var string */
    protected $model = \App\Models\Organisation::class;

    /** @var string Filter */
    protected $filter = OrganisationFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organisation $organisation)
    {
        return $this->crudShow($organisation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organisation $organisation)
    {
        return $this->crudEdit($organisation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrganisation $request, Organisation $organisation)
    {
        return $this->crudUpdate($request, $organisation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organisation $organisation)
    {
        return $this->crudDestroy($organisation);
    }

    /**
     * @param Organisation $organisation
     */
    public function organisations(Organisation $organisation)
    {
        $this->authCheck($organisation);

        $options = ['organisation' => $organisation];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['organisation_id'] = $organisation->id;
            $filters['organisation_id'] = $organisation->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Organisation\Organisation::class)
            ->route('organisations.organisations', $options);

        // @phpstan-ignore-next-line
        $this->rows = $organisation
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->with([
                'entity', 'entity.image', 'entity.tags',
                'organisation', 'organisation.entity'
            ])
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($organisation, 'organisations');
    }

    /**
     * @param Organisation $organisation
     */
    public function members(Organisation $organisation)
    {
        $this->authCheck($organisation);

        $options = ['organisation' => $organisation];
        $base = 'members';
        if (request()->has('all')) {
            $options['all'] = true;
            $base = 'allMembers';
        }
        Datagrid::layout(\App\Renderers\Layouts\Organisation\Member::class)
            ->route('organisations.members', $options)
            ->actionParams(['from' => 'org']);

        $this->rows = $organisation
            ->{$base}()
            ->with([
                'organisation', 'organisation.entity',
                'parent', 'parent.character',
                'character', 'character.entity', 'character.entity.image',
                'character.location', 'character.location.entity'])
            ->has('character')
            ->has('character.entity')
            ->sort(request()->only(['o', 'k']))
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
            ->menuView($organisation, 'members');
    }
}
