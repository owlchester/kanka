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
            'label' => '<i class="fa fa-list"></i> ' . trans( $this->view . '.index.title')
        ]];

        $search = $model
            ->acl()
            ->filter($this->filterService->filters())
            ->search(request()->get('search'))
            ->order($this->filterService->order());

        $singularModel = str_singular($this->view);

        $parentKey = !empty($this->treeControllerParentKey) ? $this->treeControllerParentKey : $singularModel . '_id';
        if (request()->has('parent_id')) {
            $search = $search->where([$parentKey => request()->get('parent_id')]);

            $parent = $model->with($singularModel)->where('id', request()->get('parent_id'))->first();
            if (!empty($parent) && !empty($parent->$singularModel)) {
                // Go back to parent
                $actions[] = [
                    'route' => route($this->route . '.tree', ['parent_id' => $parent->$singularModel->id]),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . $parent->$singularModel->name
                ];
            } else {
                // Go back to first level
                $actions[] = [
                    'route' => route($this->route . '.tree'),
                    'class' => 'default',
                    'label' => '<i class="fa fa-arrow-left"></i> ' . trans('crud.actions.back')
                ];
            }
        } else {
            $search = $search->whereNull($parentKey);
        }

        $models = $search->paginate();
        $view = $this->view;
        $route = $this->route;

        return view('cruds.tree', compact('models', 'name', 'model', 'actions', 'filters', 'filterService', 'view', 'route'));
    }
}