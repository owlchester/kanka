<?php

namespace App\Traits;

use App\Models\MiscModel;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

trait TreeControllerTrait
{
    /**
     * Tree / Exploration mode
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
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
        $templates = $this->loadTemplates($model);


        $mode = request()->get('m', 'grid');
        if (!in_array($mode, ['grid', 'table'])) {
            $mode = 'grid';
        }

        if ($mode === 'table') {
            $this->addNavAction(
                route($this->route . '.index', ['m' => 'table']),
                '<i class="fa-solid fa-list" aria-hidden="true"></i> ' . __('entities.' . $this->view)
            );
        }

        $base = $model
            ->preparedSelect()
            ->preparedWith()
            ->search(request()->get('search'))
            ->order($this->filterService->order())
            ->distinct();

        /** @var Tag $model **/
        //$parentKey = $model->getTable() . '.' . (!empty($this->treeControllerParentKey) ?
        //        $this->treeControllerParentKey : $singularModel . '_id');
        $parentKey = $model->getParentIdName();
        $parent = null;
        if (request()->has('parent_id')) {
            $base->where([$parentKey => request()->get('parent_id')]);

            $parent = $model->where('id', request()->get('parent_id'))->first();
            if (request()->get('m') === 'table') {
                if (!empty($parent) && !empty($parent->child)) {
                    // Go back to previous parent
                    $this->addNavAction(
                        route($this->route . '.tree', ['parent_id' => $parent->child->id]),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . $parent->child->name
                    );
                } else {
                    // Go back to first level
                    $this->addNavAction(
                        route($this->route . '.tree'),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . __('crud.actions.back')
                    );
                }
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
            /** @var LengthAwarePaginator $models */
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
            'filter',
            'filters',
            'filterService',
            'filteredCount',
            'unfilteredCount',
            'route',
            'bulk',
            'templates',
            'datagridActions',
            'parent',
            'mode',
        ));
    }
}
