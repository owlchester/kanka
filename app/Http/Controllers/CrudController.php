<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\DefaultDatagridActions;
use App\Datagrids\Filters\DatagridFilter;
use App\Datagrids\Sorters\DatagridSorter;
use App\Facades\Breadcrumb;
use App\Facades\FormCopy;
use App\Facades\Module;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Renderers\DatagridRenderer;
use App\Sanitizers\MiscSanitizer;
use App\Services\AttributeService;
use App\Services\Entity\CopyService;
use App\Services\FilterService;
use App\Services\MultiEditingService;
use App\Traits\BulkControllerTrait;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasNested;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use LogicException;

class CrudController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasNested;
    use HasSubview;

    /** The view where to find the resources */
    protected string $view = '';

    /** The name of the route for the resource */
    protected string $route = '';

    /** Model class name for the object */
    protected string $model;

    /** Name of the campaign module to test if it's enabled or not */
    protected string $module;

    protected string $filter;

    protected FilterService $filterService;

    protected DatagridRenderer $datagrid;

    /** If the permissions tab and pane is enabled or not. */
    protected bool $tabPermissions = true;

    /** If the attributes tab and pane is enabled or not */
    protected bool $tabAttributes = true;

    /** If the copy tab and pane is enabled or not */
    protected bool $tabCopy = true;

    /** If the boosted tab and pane is enabled or not */
    protected bool $tabBoosted = true;

    /** List of navigation actions on top of the datagrids */
    protected array $navActions = [];

    /** Make the request play nice with the model */
    protected string $sanitizer;

    /**
     * A sorter object for subviews
     */
    protected DatagridSorter $datagridSorter;

    protected AttributeService $attributeService;

    /** If the auth check was already performed on this controller */
    protected bool $alreadyAuthChecked = false;

    /** The datagrid actions, set to null to disable */
    protected string $datagridActions = DefaultDatagridActions::class;

    /** Determine if the create/store procedure has a limit checking in place */
    protected bool $hasLimitCheck = false;

    protected Request $request;

    public function __construct(FilterService $filterService, DatagridRenderer $datagridRenderer, AttributeService $attributeService)
    {
        $this->filterService = $filterService;
        $this->datagrid = $datagridRenderer;
        $this->attributeService = $attributeService;
    }

    public function index(Request $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudIndex($request);
    }

    public function crudIndex(Request $request)
    {
        if (! $this->moduleEnabled()) {
            return redirect()->route('dashboard', $this->campaign)->with(
                'error_raw',
                __('campaigns/modules.errors.disabled', [
                    'name' => $this->getEntityType()->plural(), // @phpstan-ignore-line
                    'fix' => '<a href="' . route('campaign.modules', [$this->campaign, '#' . $this->getEntityType()->code]) . '">' . __('crud.fix-this-issue') . '</a>', // @phpstan-ignore-line
                ])
            );
        }

        /**
         * Prepare a lot of variables that will be shared over to the view
         *
         * @var MiscModel $model
         */
        $model = new $this->model;
        $campaign = $this->campaign;
        $this->request = $request;
        $this->filterService
            ->request($request);
        if (method_exists($model, 'explicitFilters')) {
            $this->filterService
                ->model($model)
                ->make($this->view);
        }
        $name = $this->view;
        $langKey = $this->langKey ?? $name;
        /** @var ?DatagridFilter $filter */
        $filter = ! empty($this->filter) ? new $this->filter : null;
        if (! empty($filter)) {
            $filter->campaign($this->campaign)->build();
        }
        $route = $this->route;
        $bulk = $this->bulkModel();
        $datagridActions = new $this->datagridActions;

        // Switch between the new explore/grid mode and the old table
        $mode = $this->mode();
        $forceMode = null;
        if (property_exists($this, 'forceMode')) {
            $mode = $forceMode = $this->forceMode;
        }
        $nested = $this->isNested();

        if ($mode === 'grid') {
            $base = $model
                ->preparedGrid();
        } else {
            $base = $model
                ->preparedSelect()
                ->preparedWith();
            if ($nested) {
                $this->datagrid->nested();
            }
        }

        $base->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct();

        $parent = null;
        if (request()->has('parent_id') && method_exists($model, 'getParentKeyName')) {
            $parentKey = $model->getParentKeyName();
            $base->where([$model->getTable() . '.' . $parentKey => request()->get('parent_id')]);

            $parent = $model->where('id', request()->get('parent_id'))->first();
            if ($mode === 'table') {
                if (! empty($parent) && ! empty($parent->parent)) {
                    // Go back to previous parent
                    $this->addNavAction(
                        route($this->route . '.index', [$campaign, 'parent_id' => $parent->parent->id]),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . $parent->parent->name
                    );
                } else {
                    // Go back to first level
                    $this->addNavAction(
                        route($this->route . '.index', [$campaign]),
                        '<i class="fa-solid fa-arrow-left" aria-hidden="true"></i> ' . __('crud.actions.back')
                    );
                }
            }
        } elseif ($nested && $this->filterService->activeFiltersCount() === 0) {
            // @phpstan-ignore-next-line
            $base->whereNull($model->getTable() . '.' . $model->getParentKeyName());
        }

        // Do this to avoid an extra sql query when no filters are selected
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            // @phpstan-ignore-next-line
            $base = $base->filter($this->filterService->filters());

            $models = $base->paginate();

            // Don't use total as it won't use the distinct() filters (typically when doing
            // left join on the entities table)
            $filteredCount = $models->total();
        } else {
            /** @var Paginator $models */
            $models = $base->paginate();
            $unfilteredCount = $filteredCount = $models->count();
        }

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) request()->get('page', 1) > $models->lastPage()) {
            return redirect()->route($this->route . '.index', [
                $this->campaign,
                'page' => $models->lastPage(),
                'order' => request()->get('order'),
            ]);
        }

        $this->setNavActions();
        $actions = $this->navActions;

        $data = compact(
            'campaign',
            'models',
            'name',
            'langKey',
            'model',
            'actions',
            'filter',
            'filteredCount',
            'unfilteredCount',
            'route',
            'bulk',
            'datagridActions',
            'mode',
            'parent',
            'forceMode',
        );
        if (method_exists($this, 'getEntityType')) {
            $data['entityType'] = $this->getEntityType();
            $data['templates'] = $this->loadTemplates($data['entityType']);
        } else {
            $data['singular'] = __('entities.' . \Illuminate\Support\Str::singular($route));
        }

        if (method_exists($this, 'titleKey')) {
            $data['titleKey'] = $this->titleKey();
        } elseif ($this->campaign->boosted()) {
            // Custom sidebar link, with fallback on custom module plural name
            $data['titleKey'] = Arr::get($campaign->ui_settings, 'sidebar.labels.' . $langKey);
            if (empty($data['titleKey']) && isset($data['entityType'])) {
                $data['titleKey'] = $data['entityType']->plural();
            }
            // If its a bookmark, override everything else
            if ($request->has('bookmark')) {
                $bookmark = Bookmark::where('id', $request->get('bookmark'))->first();
                if ($bookmark) {
                    $this->datagrid->bookmark($bookmark);
                    $data['bookmark'] = $bookmark;
                    $data['titleKey'] = $bookmark->name;
                }
            }

            if ($request->has('order')) {
                $data['order'] = $request->get('order');
                $data['desc'] = $request->get('desc');
            }
        }

        if (method_exists($model, 'getParentKeyName')) {
            $data['nestable'] = $nested;
        }
        $this->datagrid
            ->models($models)
            ->campaign($campaign)
            ->request($request)
            ->service($this->filterService);
        if (auth()->check()) {
            $this->datagrid->user(auth()->user());
        }

        $data['datagrid'] = $this->datagrid;
        $data['filterService'] = $this->filterService;

        return view('cruds.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        return $this->campaign($campaign)->crudCreate();
    }

    public function crudCreate($params = [])
    {
        // @phpstan-ignore-next-line
        $this->authorize('create', [$this->getEntityType(), $this->campaign]);

        if ($this->hasLimitCheck) {
            // @phpstan-ignore-next-line
            if ($this->limitCheckReached()) {
                $key = $this->view == 'bookmarks' ? 'bookmarks' : 'entities';

                return view('cruds.forms.limit')
                    ->with('campaign', $this->campaign)
                    ->with('key', $key)
                    ->with('name', $this->view);
            }
        }
        FormCopy::request(request());
        if (! isset($params['source'])) {
            $copyId = request()->input('copy');
            if (! empty($copyId)) {
                /** @var ?Entity $model */
                $model = Entity::find(request()->get('copy'));
                if (! $model || $model->isMissingChild()) {
                    abort(404);
                }
                $params['source'] = $model;
                FormCopy::source($params['source']);
            } else {
                $params['source'] = null;
            }
        }
        $model = new $this->model;

        $params['campaign'] = $this->campaign;
        $params['tabAttributes'] = $this->tabAttributes && $this->campaign->enabled('entity_attributes');
        $params['tabPermissions'] = $this->tabPermissions;
        $params['tabCopy'] = $this->tabCopy;
        $params['tabBoosted'] = $this->tabBoosted;
        if (method_exists($this, 'getEntityType')) {
            $params['entityType'] = $this->getEntityType();
            $params['tabPermissions'] = $this->tabPermissions && auth()->user()->can('permissions', $params['entityType']);
        }
        $params['title'] = __($this->view . '.create.title');

        // Custom module names shenanigans
        $entityTypeID = $model->entityTypeId();
        $plural = Module::plural($entityTypeID, __('entities.' . $this->view));
        $singular = Module::singular($entityTypeID);
        $params['entityTypeId'] = $entityTypeID;
        $params['plural'] = $plural;
        if (! empty($singular)) {
            $params['title'] = __('crud.titles.new', ['module' => $singular]);
        }

        $view = 'cruds.forms.create';
        $override = $this->view . '.forms.create';
        if (view()->exists($override)) {
            $view = $override;
        }

        return view($view, array_merge(['name' => $this->view], $params));
    }

    public function crudStore(Request $request, bool $redirectToCreated = false)
    {
        // @phpstan-ignore-next-line
        $this->authorize('create', [$this->getEntityType(), $this->campaign]);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        if ($this->hasLimitCheck) {
            // @phpstan-ignore-next-line
            if ($this->limitCheckReached()) {
                return redirect()->back();
            }
        }

        try {
            // Sanitize the data
            if (isset($this->sanitizer)) {
                /** @var MiscSanitizer $sanitizer */
                $sanitizer = app()->make($this->sanitizer);
                $request->merge($sanitizer->request($request)->sanitize());
            }

            $data = $request->all();
            $data['campaign_id'] = $this->campaign->id;

            /** @var MiscModel $model */
            $model = new $this->model;
            /** @var MiscModel $new */
            $new = $model->create($data);

            // Fire an event for the Entity Observer.
            if (method_exists($model, 'crudSaved')) {
                $new->crudSaved();
            }

            // Bookmarks have no entity attached to them.
            if (! ($new instanceof Bookmark) && $new->entity) {
                $new->entity->crudSaved();
                // Weird hack for prod issues
                if (! $new->entity->child) {
                    $new->entity->child = $new;
                }

                /** @var CopyService $copyService */
                $copyService = app()->make(CopyService::class);
                // First copy stuff like posts, since we might replace attribute mentions next
                $copyService->entity($new->entity)->request($request)->fromId()->copy();

                if (auth()->user()->can('attributes', $new->entity)) {
                    $this->attributeService
                        ->campaign($this->campaign)
                        ->entity($new->entity)
                        ->save($request->get('attribute', []));

                    // When copying an entity, the user probably wants to update all mentions of attributes to ones on the new entity.
                    if ($request->has('replace_mentions') && $request->filled('replace_mentions') && $new->entity->isFillable('entry')) {
                        $this->attributeService
                            ->replaceMentions((int) $request->post('copy_source_id'));
                    }
                }
            }

            $link = '<a href="' . route(
                $new->entity ? 'entities.show' : $this->view . '.show',
                $new->entity ? [$this->campaign, $new->entity] : [$this->campaign, $new->id]
            )
                . '">' . $new->name . '</a>';
            $success = __('general.success.created', [
                'name' => $link,
            ]);

            session()->flash('success_raw', $success);

            if ($request->has('submit-new')) {
                $route = route($this->route . '.create', $this->campaign);

                return response()->redirectTo($route);
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', [$this->campaign, $new]);
                if (! $new instanceof Bookmark) {
                    $route = route('entities.edit', [$this->campaign, $new->entity]);
                }

                return response()->redirectTo($route);
            } elseif ($request->has('submit-view') && $new->entity) {
                $route = route('entities.show', [$this->campaign, $new->entity]);

                return response()->redirectTo($route);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', [$this->campaign, 'copy' => $new->id]);

                return response()->redirectTo($route);
            }

            if ($new->entity) {
                $route = route('entities.show', [$this->campaign, $new->entity]);

                return response()->redirectTo($route);
            }
            $route = Breadcrumb::campaign($this->campaign)->index($this->route);

            return response()->redirectTo($route);
        } catch (LogicException $exception) {
            if (config('app.debug')) {
                throw $exception;
            }
            $error = str_replace(' ', '_', mb_strtolower($exception->getMessage()));

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('crud.errors.' . $error));
        }
    }

    public function crudShow(Model|MiscModel $model)
    {
        // @phpstan-ignore-next-line
        if (! $model->entity) {
            abort(404);
        }

        return redirect()->route('entities.show', [$this->campaign, $model->entity]);
    }

    public function crudEdit(Model|MiscModel $model, array $params = [])
    {
        $this->authorize('update', $model instanceof MiscModel ? $model->entity : $model);

        if ($model instanceof MiscModel) {
            return redirect()->route('entities.edit', [$this->campaign, $model->entity]);
        }

        /** @var MiscModel $model */
        $editingUsers = null;

        if ($this->campaign->hasEditingWarning() && $model->entity) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($model->entity)->user(auth()->user())->users();
            // If no one is editing the entity, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        $params = array_merge($params, [
            'campaign' => $this->campaign,
            'model' => $model,
            'name' => $this->view,
            'tabPermissions' => $this->tabPermissions && auth()->user()->can('permissions', $model),
            'tabAttributes' => $this->tabAttributes && auth()->user()->can('attributes', $model->entity) && $this->campaign->enabled('entity_attributes'),
            'tabBoosted' => $this->tabBoosted,
            'tabCopy' => $this->tabCopy,
            'editingUsers' => $editingUsers,
        ]);
        if (! $model instanceof Bookmark && $model->entity) {
            $params['entity'] = $model->entity;
        }

        $view = 'cruds.forms.edit';
        $override = $this->view . '.forms.edit';
        if (view()->exists($override)) {
            $view = $override;
        }

        return view($view, $params);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function crudUpdate(Request $request, Model|MiscModel $model)
    {
        $this->authorize('update', $model instanceof MiscModel ? $model->entity : $model);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            // Sanitize the data
            if (isset($this->sanitizer)) {
                /** @var MiscSanitizer $sanitizer */
                $sanitizer = app()->make($this->sanitizer);
                $request->merge($sanitizer->request($request)->sanitize());
            }

            /** @var MiscModel $model */
            $data = $this->prepareData($request, $model);
            $model->update($data);

            // Fire an event for the Entity Observer
            $model->crudSaved();

            // Bookmarks have no entity attached to them.
            if ($model->entity) {
                $model->entity->name = $model->name;
                $model->entity->is_private = $model->is_private;
                $model->entity->crudSaved();
                // If the child was changed but nothing changed on the entity, we still want to trigger an update
                if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                    $model->entity->touch();
                }

                if (auth()->user()->can('attributes', $model->entity)) {
                    $this->attributeService
                        ->campaign($this->campaign)
                        ->entity($model->entity)
                        ->save($request->get('attribute', []));
                }
            }

            $link = '<a href="' . route(
                $model->entity ? 'entities.show' : $this->view . '.show',
                $model->entity ? [$this->campaign, $model->entity] : [$this->campaign, $model->id]
            )
                . '">' . $model->name . '</a>';
            $success = __('general.success.updated', [
                'name' => $link,
            ]);

            if ($model->entity) {
                /** @var MultiEditingService $editingService */
                $editingService = app()->make(MultiEditingService::class);
                $editingService->model($model->entity)
                    ->user($request->user())
                    ->finish();
            }

            session()->flash('success_raw', $success);

            $options = [];
            if (request()->has('redirect')) {
                $redirect = explode('&', request()->get('redirect'));
                foreach ($redirect as $option) {
                    $vals = explode('=', $option);
                    $options[$vals[0]] = $vals[1];
                }
            }
            if ($model->entity) {
                $route = route('entities.show', $options + [$this->campaign, $model->entity]);
            } else {
                $options = [$this->campaign, $model] + $options;
                $route = route($this->view . '.show', $options + [$model]);
            }
            if ($request->has('submit-new')) {
                $route = route($this->route . '.create', $this->campaign);
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', [$this->campaign, $model->id]);
            } elseif ($request->has('submit-close')) {
                $route = route($this->route . '.index', [$this->campaign]);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', [$this->campaign, 'copy' => $model->id]);

                return response()->redirectTo($route);
            }

            return response()->redirectTo($route);
        } catch (LogicException $exception) {
            $error = str_replace(' ', '_', mb_strtolower(mb_rtrim($exception->getMessage(), '.')));

            return redirect()->back()->withInput()->with('error', __('crud.errors.' . $error));
        }
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function crudDestroy(Model|MiscModel $model)
    {
        /** @var MiscModel $model */
        $this->authorize('delete', $model instanceof MiscModel ? $model->entity : $model);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model->delete();

        return redirect()->route($this->route . '.index', $this->campaign)
            ->with('success_raw', __('general.success.deleted-cancel', [
                'name' => $model->name,
                // @phpstan-ignore-next-line
                'cancel' => '<a href="' . route('recovery', $model->campaign) . '">' . __('crud.cancel') . '</a>',
            ]));
    }

    /**
     * @return array
     */
    protected function prepareData(Request $request, MiscModel $model)
    {
        $data = $request->all();
        foreach ($model->nullableForeignKeys as $field) {
            if (! request()->has($field) && ! isset($data[$field])) {
                $data[$field] = null;
            }
        }

        return $data;
    }

    /**
     * Set the datagrid sorter for sub views
     */
    protected function datagridSorter(string $datagridSorter): self
    {
        $this->datagridSorter = new $datagridSorter;
        $this->datagridSorter->request(request()->all());

        return $this;
    }

    /**
     * Detect if a module is enabled
     */
    protected function moduleEnabled(): bool
    {
        return ! isset($this->module) || $this->campaign->enabled($this->module);
    }

    /**
     * Add a button to the top of a datagrid
     *
     * @param  string  $route
     */
    protected function addNavAction($route, string $label, string $class = '', bool $blank = false): self
    {
        $this->navActions[] = [
            'route' => $route,
            'class' => $class,
            'label' => $label,
            'blank' => $blank,
        ];

        return $this;
    }

    protected function setNavActions(): self
    {
        return $this;
    }

    /**
     * Set the controller as having a limit check
     */
    protected function hasLimitCheck(bool $value = true): self
    {
        $this->hasLimitCheck = $value;

        return $this;
    }

    /**
     * Load a list of templates the user can create new entities from
     */
    protected function loadTemplates(EntityType $entityType): Collection
    {
        // No valid user, or invalid entity type (ie relations)
        if (auth()->guest()) {
            return new Collection;
        } elseif (! auth()->user()->can('create', [$entityType, $this->campaign])) {
            return new Collection;
        }

        return Entity::select('id', 'name', 'entity_id')
            ->templates($entityType->id)
            ->orderBy('name')
            ->get();
    }

    /**
     * Determine if the layout is in the nice grid mode, or the old table mode
     */
    protected function mode(): string
    {
        if (! isset($this->module)) {
            return 'table';
        }
        $key = $this->module . '_mode';
        if ($this->request->has('m')) {
            $mode = $this->request->get('m');
            if (! in_array($mode, ['grid', 'table'])) {
                return 'grid';
            }
            $newMode = $mode;
        }
        if (isset($newMode)) {
            if (auth()->guest()) {
                Session::put($key, $newMode);
            } else {
                $settings = auth()->user()->settings;
                if (auth()->check() && Arr::get($settings, $key) !== $newMode) {
                    if ($newMode === 'grid') {
                        unset($settings[$key]);
                    } else {
                        $settings[$key] = $newMode;
                    }
                    auth()->user()->settings = $settings;
                    auth()->user()->updateQuietly();
                }
            }

            return $newMode;
        }

        if (auth()->guest()) {
            return Session::get($key, 'grid');
        }

        // Else use the user's preferred stacking for this entity type
        return Arr::get(auth()->user()->settings, $key, 'grid');
    }

    /**
     * Determine if the current layout should be nested or not
     */
    protected function isNested(): bool
    {
        // Model isn't nested, not an option to start with
        if (! isset($this->module) || ! method_exists($this->model, 'getParentKeyName')) {
            return false;
        }
        $key = $this->module . '_nested';
        if ($this->request->has('n')) {
            return $this->saveNested($key);
        }

        if (auth()->guest()) {
            return (bool) Session::get($key, true);
        }

        // Else use the user's preferred stacking for this entity type
        return Arr::get(auth()->user()->settings, $key, true);
    }
}
