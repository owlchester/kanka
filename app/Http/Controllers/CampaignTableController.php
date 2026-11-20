<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\DatagridFilter;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Relation;
use App\Renderers\DatagridRenderer;
use App\Services\FilterService;
use App\Traits\BulkControllerTrait;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class CampaignTableController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    protected string $view;

    /** @var class-string<Bookmark|Relation> */
    protected string $model;

    /** @var class-string<DatagridFilter> */
    protected string $filter;

    protected string $langKey;

    public function __construct(
        protected FilterService $filterService,
        protected DatagridRenderer $datagrid,
    ) {}

    public function index(Request $request, Campaign $campaign)
    {
        $this->campaign($campaign);
        $model = new $this->model;
        $name = $route = $this->view;
        $langKey = $this->langKey ?? $name;
        $filter = isset($this->filter) ? new $this->filter : null;
        $filter?->campaign($campaign)->build();
        $bulk = $this->bulkModel($model);
        $datagridActions = new $this->datagridActions;

        $this->filterService->request($request);
        if (method_exists($model, 'explicitFilters')) {
            $this->filterService->model($model)->make($name);
        }

        $base = $model->preparedSelect()->preparedWith()
            ->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct();

        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            $models = $base->filter($this->filterService->filters())->paginate();
            $filteredCount = $models->total();
        } else {
            if ($model instanceof Relation) {
                $base->whereHas('owner', fn ($query) => $query->whereNull('entities.archived_at'))
                    ->whereHas('target', fn ($query) => $query->whereNull('entities.archived_at'));
            }
            $models = $base->paginate();
            $unfilteredCount = $filteredCount = $models->count();
        }

        if ((int) $request->query('page', 1) > $models->lastPage()) {
            return redirect()->route($route . '.index', [
                $campaign,
                'page' => $models->lastPage(),
                'order' => $request->query('order'),
            ]);
        }

        $data = compact('campaign', 'models', 'name', 'langKey', 'model', 'filter', 'filteredCount', 'unfilteredCount', 'route', 'bulk', 'datagridActions');
        $data['mode'] = 'table';
        if ($model instanceof Bookmark) {
            $type = EntityType::findOrFail(config('entities.ids.bookmark'));
            $data['entityType'] = $type;
            $data['templates'] = collect();
            $this->datagrid->entityType($type);

            if ($campaign->boosted()) {
                $data['titleKey'] = Arr::get($campaign->ui_settings, 'sidebar.labels.' . $langKey) ?: $type->plural();
                if ($request->filled('bookmark')) {
                    $bookmark = Bookmark::where('campaign_id', $campaign->id)->find($request->query('bookmark'));
                    if ($bookmark) {
                        $this->datagrid->bookmark($bookmark);
                        $data['bookmark'] = $bookmark;
                        $data['titleKey'] = $bookmark->name;
                    }
                }
            }
        } else {
            $data['singular'] = __('entities.relation');
            $data['titleKey'] = __('sidebar.relations');
        }

        $this->datagrid->models($models)->campaign($campaign)->request($request)->service($this->filterService);
        if ($request->user()) {
            $this->datagrid->user($request->user());
        }

        return view('cruds.index', $data + ['datagrid' => $this->datagrid, 'filterService' => $this->filterService]);
    }
}
