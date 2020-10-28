<?php

namespace App\Traits;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait TreeControllerTrait
{
    /**
     * This can be overwritten in the controller to specify the parent key
     * @var string
     */
    //protected $treeControllerParentKey = '';

    /**
     * Tree / Exploration mode
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tree(Request $request)
    {
        /** @var MiscModel $model */
        $model = new $this->model;
        $this->filterService->make($this->view . 'tree', request()->all(), $model);
        $name = $this->view;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $filter = !empty($this->filter) ? new $this->filter : null;

        // Entity templates
        $templates = auth()->check() && auth()->user()->isAdmin() ? Entity::templates($model->getEntityType())->get() : null;

        $actions = [[
            'route' => route($this->route . '.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans($this->view . '.index.title')
        ]];

        $base = $model
            ->distinct()
            ->preparedWith()
            ->search(request()->get('search'))
            ->order($this->filterService->order());

        $singularModel = Str::singular($this->view);
        $createOptions = [];

        /** @var Tag $model **/
        $parentKey = $model->getTable() . '.' . (!empty($this->treeControllerParentKey) ? $this->treeControllerParentKey : $singularModel . '_id');
        if (request()->has('parent_id')) {
            $base->where([$parentKey => request()->get('parent_id')]);

            $parent = $model->with($singularModel)->where('id', request()->get('parent_id'))->first();
            if (!empty($parent) && !empty($parent->$singularModel)) {
                // Go back to parent
                $actions[] = [
                    'route' => route($this->route . '.tree', ['parent_id' => $parent->$singularModel->id]),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . $parent->$singularModel->name
                ];
                $createOptions['parent_id'] = $parent->id;
            } else {
                // Go back to first level
                $actions[] = [
                    'route' => route($this->route . '.tree'),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . trans('crud.actions.back')
                ];
                $createOptions['parent_id'] = $parent->id;
            }
        } else {
            $base->whereNull($parentKey);
        }

        // Do this to avoid an extra sql query when no filters are selected
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            $base = $base->filter($this->filterService->filters());

            $models = $base->paginate();
            $filteredCount = $models->total();
        } else {
            $models = $base->paginate();
            $unfilteredCount = $filteredCount = $models->total();
        }

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) request()->get('page', 1) > $models->lastPage()) {
            return redirect()->route($this->route . '.tree', [
                'page' => $models->lastPage(),
                'order' => request()->get('order')
            ]);
        }

        $view = $this->view;
        $route = $this->route;
        $bulk = $this->bulkModel();

        return view('cruds.tree', compact(
            'models',
            'name',
            'model',
            'actions',
            'filters',
            'filterService',
            'filter',
            'view',
            'route',
            'bulk',
            'unfilteredCount',
            'filteredCount',
            'createOptions',
            'templates'
        ));
    }
}
