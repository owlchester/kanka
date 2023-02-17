<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\FamilyFilter;
use App\Facades\Datagrid;
use App\Http\Requests\StoreFamily;
use App\Models\Campaign;
use App\Models\Family;
use App\Traits\TreeControllerTrait;

class FamilyController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'families';
    protected string $route = 'families';
    protected $module = 'families';

    /**
     * Crud models
     */
    protected $model = \App\Models\Family::class;

    /** @var string Filter */
    protected $filter = FamilyFilter::class;

    public function store(StoreFamily $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudShow($family);
    }

    public function edit(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudEdit($family);
    }

    public function update(StoreFamily $request, Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudUpdate($request, $family);
    }

    public function destroy(Campaign $campaign, Family $family)
    {
        return $this->campaign($campaign)->crudDestroy($family);
    }

    /**
     * @param Family $family
     */
    public function members(Campaign $campaign, Family $family)
    {
        $this->authCheck($family);

        $options = ['campaign' => $campaign, 'family' => $family];
        $filters = [];
        $relation = 'allMembers';
        if (request()->has('family_id')) {
            $options['family_id'] = $family->id;
            $filters['family_id'] = $options['family_id'];
            $relation = 'members';
        }
        Datagrid::layout(\App\Renderers\Layouts\Family\Character::class)
            ->route('families.members', $options);

        $this->rows = $family
            ->{$relation}()
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with([
                'location', 'location.entity',
                'families', 'families.entity',
                'races', 'races.entity',
                'entity', 'entity.tags', 'entity.image'
            ])
            ->has('entity')
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($family, 'members');
    }
}
