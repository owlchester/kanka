<?php

namespace App\Traits;

use App\Datagrids\Filters\DatagridFilter;
use App\Facades\Module;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait TreeControllerTrait
{
    /**
     * Tree / Exploration mode
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function tree(Request $request, Campaign $campaign)
    {
        $this->campaign = $campaign;
        if (!$this->moduleEnabled()) {
            return redirect()->route('dashboard', $this->campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), [$this->campaign, '#' . $this->module]),
                ])
            );
        }

        /**
         * Prepare a lot of variables that will be shared over to the view
         * @var MiscModel $model
         */
        $model = new $this->model();
        $this->filterService
            ->request($request)
            ->model($model)
            ->make($this->view . 'tree');
        $name = $this->view;
        $filterService = $this->filterService;
        /** @var DatagridFilter|null $filter */
        $filter = !empty($this->filter) ? new $this->filter() : null;
        if (!empty($filter)) {
            $filter->campaign($this->campaign)->build();
        }
        $langKey = $this->langKey ?? $name;
        $templates = $this->loadTemplates($model);


        $mode = request()->get('m', 'grid');
        if (!in_array($mode, ['grid', 'table'])) {
            $mode = 'grid';
        }

        if ($mode === 'table') {
            $this->addNavAction(
                route($this->route . '.index', [$this->campaign, 'm' => 'table']),
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
        $parentKey = $model->getParentKeyName();
        $parent = null;
        if (request()->has('parent_id')) {
            $base->where([$model->getTable() . '.' . $parentKey => request()->get('parent_id')]);

            $parent = $model->where('id', request()->get('parent_id'))->first();
            if (request()->get('m') === 'table') {
                if (!empty($parent) && !empty($parent->parent)) {
                    // Go back to previous parent
                    $this->addNavAction(
                        route($this->route . '.tree', [$campaign, 'parent_id' => $parent->parent->id, 'm' => 'table']),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . $parent->parent->name
                    );
                } else {
                    // Go back to first level
                    $this->addNavAction(
                        route($this->route . '.tree', [$campaign, 'm' => 'table']),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . __('crud.actions.back')
                    );
                }
            }
        } else {
            $base->whereNull($model->getTable() . '.' . $parentKey);
        }

        // Do this to avoid an extra sql query when no filters are selected
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            // @phpstan-ignore-next-line
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
                $campaign,
                'page' => $models->lastPage(),
                'order' => request()->get('order')
            ]);
        }

        $route = $this->route;
        $datagridActions = new $this->datagridActions();
        $bulk = $this->bulkModel();
        $actions = $this->navActions;
        $campaign = $this->campaign;
        $this->getNavActions();

        $entityTypeId = $model->entityTypeId();
        if (method_exists($this, 'titleKey')) {
            $titleKey = $this->titleKey();
        } else {
            $titleKey = Module::plural($entityTypeId, __('entities.' . $langKey));
        }
        $singular = Module::singular($entityTypeId, __('entities.' . \Illuminate\Support\Str::singular($route)));

        return view('cruds.tree', compact(
            'campaign',
            'models',
            'name',
            'langKey',
            'model',
            'actions',
            'filter',
            'filterService',
            'filteredCount',
            'unfilteredCount',
            'route',
            'bulk',
            'templates',
            'datagridActions',
            'parent',
            'mode',
            'titleKey',
            'entityTypeId',
            'singular',
        ));
    }
}
