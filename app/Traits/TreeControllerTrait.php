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
        if (!$this->moduleEnabled()) {
            return redirect()->route('dashboard')->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), ['#' . $this->module]),
                ])
            );
        }

        /**
         * Prepare a lot of variables that will be shared over to the view
         * @var MiscModel $model
         */
        $model = new $this->model();
        $this->filterService->make($this->view . 'tree', request()->all(), $model);
        $name = $this->view;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $filter = !empty($this->filter) ? new $this->filter() : null;
        $langKey = $this->langKey ?? $name;

        $this->addNavAction(
            route($this->route . '.index'),
            '<i class="fa-solid fa-list"></i> ' . __($this->view . '.index.title')
        );

        // Entity templates
        $templates = null;
        if (auth()->check() && !empty($model->entityTypeID()) && auth()->user()->can('create', $model)) {
            $templates = Entity::templates($model->entityTypeID())
                ->get();
        }

        $base = $model
            ->distinct()
            ->preparedSelect()
            ->preparedWith()
            ->search(request()->get('search'))
            ->order($this->filterService->order());

        $singularModel = Str::singular($this->view);
        $createOptions = [];

        /** @var Tag $model **/
        $parentKey = $model->getTable() . '.' . (!empty($this->treeControllerParentKey) ?
                $this->treeControllerParentKey : $singularModel . '_id');
        $parent = null;
        if (request()->has('parent_id')) {
            $base->where([$parentKey => request()->get('parent_id')]);

            $parent = $model->with($singularModel)->where('id', request()->get('parent_id'))->first();
            if (!empty($parent) && !empty($parent->$singularModel)) {
                $this->addNavAction(
                    route($this->route . '.tree', ['parent_id' => $parent->$singularModel->id]),
                    '<i class="fa-solid fa-arrow-left"></i> ' . $parent->$singularModel->name
                );
                $createOptions['parent_id'] = $parent->id;
            } else {
                // Go back to first level
                $this->addNavAction(
                    route($this->route . '.tree'),
                    '<i class="fa-solid fa-arrow-left"></i> ' . __('crud.actions.back')
                );
                $createOptions['parent_id'] = null;
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
        $datagridActions = new $this->datagridActions();
        $bulk = $this->bulkModel();
        $actions = $this->navActions;

        return view('cruds.tree', compact(
            'models',
            'name',
            'langKey',
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
            'templates',
            'parent',
            'datagridActions'
        ));
    }
}
