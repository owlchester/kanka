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

    public function store(StoreFamily $request)
    {
        return $this->crudStore($request);
    }

    public function show(Family $family)
    {
        return $this->crudShow($family);
    }

    public function edit(Family $family)
    {
        return $this->crudEdit($family);
    }

    public function update(StoreFamily $request, Family $family)
    {
        return $this->crudUpdate($request, $family);
    }

    public function destroy(Family $family)
    {
        return $this->crudDestroy($family);
    }

    /**
     * @param Family $family
     */
    public function families(Campaign $campaign, Family $family)
    {
        $this->authCheck($family);

        $options = ['campaign' => $campaign, 'family' => $family];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $family->id;
            $filters['family_id'] = $family->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Family\Family::class)
            ->route('families.families', $options);

        // @phpstan-ignore-next-line
        $this->rows = $family
            ->descendants()
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['location', 'location.entity', 'entity', 'entity.tags'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($family, 'families');
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
