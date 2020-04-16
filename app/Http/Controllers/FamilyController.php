<?php

namespace App\Http\Controllers;

use App\Datagrids\Bulks\FamilyBulk;
use App\Datagrids\Filters\FamilyFilter;
use App\Datagrids\Sorters\FamilyCharacterSorter;
use App\Datagrids\Sorters\FamilyFamilySorter;
use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreLocation;
use App\Models\Family;
use App\Models\Location;
use App\Models\Tag;
use App\Traits\TreeControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'families';
    protected $route = 'families';

    /**
     * Crud models
     */
    protected $model = \App\Models\Family::class;

    /** @var string Filter */
    protected $filter = FamilyFilter::class;

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

    /**
     * @param Family $family
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function families(Family $family)
    {
        return $this->datagridSorter(FamilyFamilySorter::class)
            ->menuView($family, 'families');
    }

    /**
     * @param Family $family
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function members(Family $family)
    {
        return $this->datagridSorter(FamilyCharacterSorter::class)
            ->menuView($family, 'members');
    }

    /**
     * @param Family $family
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allMembers(Family $family)
    {
        return $this->datagridSorter(FamilyCharacterSorter::class)
            ->menuView($family, 'all_members');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Family $family)
    {
        return $this->menuView($family, 'map-points', true);
    }
}
