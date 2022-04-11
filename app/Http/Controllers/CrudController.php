<?php

namespace App\Http\Controllers;

use App\Datagrids\Sorters\DatagridSorter;
use App\Facades\CampaignLocalization;
use App\Facades\FormCopy;
use App\Http\Resources\AttributeResource;
use App\Models\Entity;
use App\Models\AttributeTemplate;
use App\Models\MenuLink;
use App\Models\MiscModel;
use App\Services\Entity\MultiEditingService;
use App\Services\FilterService;
use App\Traits\BulkControllerTrait;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use LogicException;

class CrudController extends Controller
{
    use GuestAuthTrait, BulkControllerTrait;

    /**
     * The view where to find the resources
     *
     * @var string
     */
    protected $view = '';

    /**
     * The name of the route for the resource
     *
     * @var string
     */
    protected $route = '';

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * Extra actions in the index view
     *
     * @var array
     */
    protected $indexActions = [];

    /**
     * @var array
     */
    protected $filters = [];
    protected $filter;

    /**
     * @var FilterService
     */
    protected $filterService;

    /**
     * If the permissions tab and pane is enabled or not.
     * @var bool
     */
    protected $tabPermissions = true;

    /**
     * If the attributes tab and pane is enabled or not.
     * @var bool
     */
    protected $tabAttributes = true;

    /**
     * If the copy tab and pane is enabled or not.
     * @var bool
     */
    protected $tabCopy = true;

    /**
     * If the boosted tab and pane is enabled or not.
     * @var bool
     */
    protected $tabBoosted = true;

    /**
     * @var bool Control if the form is "horizontal" (css class)
     */
    protected $horizontalForm = false;

    /**
     * A sorter object for subviews
     * @var null|DatagridSorter
     */
    protected $datagridSorter = null;

    /** @var bool If the bulk templates button is available */
    protected $bulkTemplates = true;

    /**
     * @var null
     */
    protected $datagrid = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('campaign.member');

        $this->filterService = new FilterService();
    }

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->crudIndex($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudIndex(Request $request)
    {
        //$this->authorize('browse', $this->model);

        // Check that the module isn't disabled
        $campaign = CampaignLocalization::getCampaign();
        if (!empty($this->module) && !$campaign->enabled($this->module)) {
            return redirect()->route('dashboard')->with('error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => link_to_route('campaign_settings', __('crud.fix-this-issue'), ['#' . $this->module]),
                ])
            );
        }

        /** @var MiscModel $model */
        $model = new $this->model;
        $this->filterService->make($this->view, request()->all(), $model);
        $name = $this->view;
        $langKey = $this->langKey ?? $name;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filter = !empty($this->filter) ? new $this->filter : null;
        $filterService = $this->filterService;
        $nestedView = method_exists($this, 'tree');
        $route = $this->route;
        $bulk = $this->bulkModel();
        $bulkTemplates = $this->bulkTemplates;

        // Entity templates
        $templates = null;
        if (auth()->check() && !empty($model->entityTypeID()) && auth()->user()->can('create', $model)) {
            $templates = Entity::templates($model->entityTypeID())
                ->acl()
                ->get();
        }

        $datagrid = !empty($this->datagrid) ? new $this->datagrid : null;

        $base = $model
            ->preparedWith()
            ->search($this->filterService->search())
            ->order($this->filterService->order())
        ;

        // Do this to avoid an extra sql query when no filters are selected
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            $base = $base->filter($this->filterService->filters());

            $models = $base->paginate();

            // Don't use total as it won't use the distinct() filters (typically when doing
            // left join on the entities table)
            $filteredCount =  count($models); //->total()
        } else {
            /** @var Paginator $models */
            $models = $base->paginate();
            $unfilteredCount = $filteredCount = $models->count();
        }

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) request()->get('page', 1) > $models->lastPage()) {
            return redirect()->route($this->route . '.index', [
                'page' => $models->lastPage(),
                'order' => request()->get('order')
            ]);
        }

        return view('cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'filter',
            'filters',
            'filterService',
            'nestedView',
            'route',
            'filteredCount',
            'unfilteredCount',
            'bulk',
            'bulkTemplates',
            'datagrid',
            'templates',
            'langKey'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->crudCreate();
    }
    public function crudCreate($params = [])
    {
        $this->authorize('create', $this->model);

        if (!isset($params['source'])) {
            $copyId = request()->input('copy');
            if (!empty($copyId)) {
                $model = new $this->model;
                $params['source'] = $model->findOrFail($copyId);
                FormCopy::source($params['source']);
            } else {
                $params['source'] = null;
            }
        }
        $model = new $this->model;
        $templates = $this->buildAttributeTemplates($model->entityTypeId());

        $params['ajax'] = request()->ajax();
        $params['tabPermissions'] = $this->tabPermissions && auth()->user()->can('permission', $model);
        $params['tabAttributes'] = $this->tabAttributes;
        $params['tabCopy'] = $this->tabCopy;
        $params['tabBoosted'] = $this->tabBoosted;
        $params['entityAttributeTemplates'] = $templates;
        $params['entityType'] = $model->getEntityType();
        $params['horizontalForm'] = $this->horizontalForm;

        return view('cruds.forms.create', array_merge(['name' => $this->view], $params));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param bool $redirectToCreated
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, $redirectToCreated = false)
    {
        $this->authorize('create', $this->model);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            /** @var MiscModel $model */
            $model = new $this->model;
            $new = $model->create($request->all());

            // Fire an event for the Entity Observer.
            $new->crudSaved();

            // MenuLink have no entity attached to them.
            if ($new->entity) {
                $new->entity->crudSaved();
            }

            $success = __('general.success.created', [
                'name' => link_to_route(
                    $this->view . '.show',
                    e($new->name),
                    $new
                )
            ]);

            session()->flash('success_raw', $success);

            if ($request->has('submit-new')) {
                $route = route($this->route . '.create');
                return response()->redirectTo($route);
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', $new);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-view')) {
                $route = route($this->route . '.show', $new);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', ['copy' => $new->id]);
                return response()->redirectTo($route);
            } elseif (auth()->user()->new_entity_workflow == 'created') {
                $redirectToCreated = true;
            } elseif ($model->getEntityType() == 'maps') {
                // If creating a map, go to edit it directly
                $route = route($this->route . '.edit', $new);
                return response()->redirectTo($route);
            }

            if ($redirectToCreated) {
                $route = route($this->route . '.show', $new);
                return response()->redirectTo($route);
            }

            $subroute = 'index';
            $campaign = CampaignLocalization::getCampaign();
            $defaultNested = auth()->user()->defaultNested || $campaign->defaultToNested();
            if ($defaultNested && \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
                $subroute = 'tree';
            }
            $route = route($this->route . '.' . $subroute);
            return response()->redirectTo($route);
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('crud.errors.' . $error));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudShow(Model $model)
    {
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $model);
        } else {
            $this->authorizeForGuest('read', $model);
        }
        $name = $this->view;
        $ajax = request()->ajax();

        // Fix for models without an entity
        if (empty($model->entity) && !($model instanceof MenuLink)) {
            $model->save();
            $model->load('entity');
        }

        return view(
            'cruds.show',
            compact('model', 'name', 'ajax')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MiscModel  $model
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model)
    {
        $this->authorize('update', $model);

        $campaign = CampaignLocalization::getCampaign();
        $editingUsers = null;

        /** @var MultiEditingService $editingService */
        if ($campaign->hasEditingWarning() && $model->entity) {
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->entity($model->entity)->user(auth()->user())->users();
            // If no one is editing the entity, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        $params = [
            'model' => $model,
            'name' => $this->view,
            'ajax' => request()->ajax(),
            'tabPermissions' => $this->tabPermissions && auth()->user()->can('permission', $model),
            'tabAttributes' => $this->tabAttributes && auth()->user()->can('attributes', $model->entity),
            'tabBoosted' => $this->tabBoosted,
            'tabCopy' => $this->tabCopy,
            'entityType' => $model->getEntityType(),
            'horizontalForm' => $this->horizontalForm,
            'editingUsers' => $editingUsers
        ];

        return view('cruds.forms.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudUpdate(Request $request, Model $model)
    {
        $this->authorize('update', $model);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            $data = $this->prepareData($request, $model);
            $model->update($data);

            // Fire an event for the Entity Observer
            $model->crudSaved();

            // MenuLink have no entity attached to them.
            if ($model->entity) {
                $model->entity->crudSaved();
            }

            $success = __('general.success.updated', [
                'name' => link_to_route(
                    $this->route . '.show',
                    e($model->name),
                    $model
                )
            ]);

            if ($model->entity) {
                /** @var MultiEditingService $editingService */
                $editingService = app()->make(MultiEditingService::class);
                $editingService->entity($model->entity)
                    ->user(auth()->user())
                    ->finish();
            }

            session()->flash('success_raw', $success);

            $options = [$model];
            if (request()->has('redirect')) {
                $redirect = explode('&', request()->get('redirect'));
                foreach ($redirect as $option) {
                    $vals = explode('=', $option);
                    $options[$vals[0]] = $vals[1];
                }
            }
            $route = route($this->route . '.show', $options);
            if ($request->has('submit-new')) {
                $route = route($this->route . '.create');
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', $model->id);
            } elseif ($request->has('submit-close')) {
                $subroute = 'index';
                $campaign = CampaignLocalization::getCampaign();
                $defaultNested = auth()->user()->defaultNested || $campaign->defaultToNested();
                if ($defaultNested && \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
                    $subroute = 'tree';
                }
                $route = route($this->route . '.' . $subroute);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', ['copy' => $model->id]);
                return response()->redirectTo($route);
            }
            return response()->redirectTo($route);
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower(rtrim($exception->getMessage(), '.')));
            return redirect()->back()->withInput()->with('error', __('crud.errors.' . $error));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudDestroy(Model $model)
    {
        $this->authorize('delete', $model);

        $model->delete();

        $subroute = 'index';
        $campaign = CampaignLocalization::getCampaign();
        $defaultNested = auth()->user()->defaultNested || $campaign->defaultToNested();
        if ($defaultNested && \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
            $subroute = 'tree';
        }

        return redirect()->route($this->route . '.' . $subroute)
            ->with('success', __('general.success.deleted', ['name' => $model->name]));
    }

    /**
     * @param $model
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function menuView($model, $view, $directView = false)
    {
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $model);
        } else {
            $this->authorizeForGuest('read', $model);
        }
        $name = $this->view;
        $fullview = $this->view . '.' . $view;
        if ($directView) {
            $fullview = 'cruds.subpage.' . $view;
        }

        $data = $markers = [];
        $datagridSorter = $this->datagridSorter;

        if ($view == 'map-points') {
            $data = $model
                ->entity
                ->targetMapPoints()
                ->orderBy('name', 'ASC')
                ->with(['location'])
                ->has('location')
                ->get();

            $markers = $model
                ->entity
                ->mapMarkers()
                ->orderBy('map_id', 'DESC')
                ->with('map')
                ->has('map')
                ->paginate();
        }

        return view('cruds.subview', compact(
            'fullview',
            'model',
            'name',
            'datagridSorter',
            'data',
            'markers',
            'view'
        ));
    }

    /**
     * @param Request $request
     * @param MiscModel $model
     * @return array
     */
    protected function prepareData(Request $request, MiscModel $model)
    {
        $data = $request->all();
        foreach ($model->nullableForeignKeys as $field) {
            if (!request()->has($field) && !isset($data[$field])) {
                $data[$field] = null;
            }
        }
        return $data;
    }

    /**
     * Get a list of all attribute templates available for this entity type.
     * @param $type
     * @return array
     */
    protected function buildAttributeTemplates($type): array
    {
        $attributeTemplates = [];
        $ids = [];
        $templates = AttributeTemplate::where(['entity_type_id' => $type])
            ->with(['entity', 'entity.attributes'])
            ->get();
        /** @var AttributeTemplate $attr */
        foreach ($templates as $attr) {
            $attributeTemplates[] = $attr;
            $ids[] = $attr->id;
            /** @var AttributeResource $child */
            foreach ($attr->ancestors()->with('entity')->get() as $child) {
                if (!in_array($child->id, $ids)) {
                    $ids[] = $child->id;
                    $attributeTemplates[] = $child;
                }
            }
        }

        return $attributeTemplates;
    }

    /**
     * Set the datagrid sorter for sub views
     * @param string $datagridFilter
     * @return $this
     */
    protected function datagridSorter(string $datagridSorter): self
    {
        $this->datagridSorter = new $datagridSorter;
        $this->datagridSorter->request(request()->all());
        return $this;
    }
}
