<?php

namespace App\Traits;

use Illuminate\Http\Request;

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
        $model = new $this->model;
        $this->filterService->prepare($this->view . 'tree', request()->all(), $model->filterableColumns());
        $name = $this->view;
        $filters = $this->filters;
        $filterService = $this->filterService;

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

        $singularModel = str_singular($this->view);
        $createOptions = [];

        $parentKey = !empty($this->treeControllerParentKey) ? $this->treeControllerParentKey : $singularModel . '_id';
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
                $createOptions['parent_id'] = $parent->$singularModel->id;
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

        $view = $this->view;
        $route = $this->route;

        return view('cruds.tree', compact(
            'models',
            'name',
            'model',
            'actions',
            'filters',
            'filterService',
            'view',
            'route',
            'unfilteredCount',
            'filteredCount',
            'createOptions'
        ));
    }
}
