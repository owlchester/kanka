<?php

namespace App\Http\Controllers\Entities;

use App\Facades\Domain;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CachedResponse;
use App\Http\Resources\Entities\ExploreResource;
use App\Http\Resources\Entities\TemplateResource;
use App\Http\Resources\EntityTypeResource;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityListingPreference;
use App\Models\EntityType;
use App\Services\Entity\ColumnDefinitionService;
use App\Services\FilterService;
use App\Services\PaginationService;
use App\Traits\Controllers\HasNested;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    use HasNested;

    protected EntityType $entityType;

    protected Campaign $campaign;

    protected Request $request;

    protected ?EntityListingPreference $preference = null;

    public function __construct(
        protected FilterService $filterService,
        protected ColumnDefinitionService $columnDefinitionService,
        protected PaginationService $paginationService,
    ) {
        $this->middleware([CachedResponse::class]);
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        if (! $entityType->isEnabled()) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns/modules.errors.disabled', [
                    'name' => $entityType->plural(),
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#' . $entityType->code]) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        } elseif ($entityType->isStandard() && ! $campaign->enabled($entityType->pluralCode())) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns/modules.errors.disabled', [
                    'name' => $entityType->plural(),
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#' . $entityType->code]) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        $this->entityType = $entityType;
        $this->campaign = $campaign;
        $this->request = $request;

        $this->filterService->request($request)->entityType($entityType)->campaign($campaign)->build(
            $this->columnDefinitionService->sortableFields($entityType, $campaign)
        );

        $nested = $this->isNested();
        $mode = $this->layoutMode();
        $title = $entityType->plural();

        $parent = null;
        if ($request->has('parent_id')) {
            $parent = Entity::select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id', 'entities.entity_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y',
            ])
                ->inTypes([$entityType->id])->where('id', $request->get('parent_id'))->first();
        }

        $apiParams = [$campaign, $entityType];
        if ($parent) {
            $apiParams['parent_id'] = $parent;
        }
        if ($request->get('_from') === 'bookmark') {
            $apiParams['_from'] = 'bookmark';
            $apiParams['bookmark'] = $request->get('bookmark');
        }
        if ($request->has('bookmark')) {
            $bookmark = Bookmark::where('id', $request->get('bookmark'))->first();
            if ($bookmark) {
                $title = $bookmark->name;
            }
        }

        return view('entities.index.index')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('mode', $mode)
            ->with('parent', $parent)
            ->with('filterService', $this->filterService)
            ->with('nestable', $nested)
            ->with('templates', new Collection)
            ->with('apiParams', $apiParams)
            ->with('title', $title);
    }

    protected function loadTemplates(Campaign $campaign, EntityType $entityType): Collection
    {
        // No valid user, or invalid entity type (ie relations)
        if (auth()->guest()) {
            return new Collection;
        } elseif (! auth()->user()->can('create', [$entityType, $campaign])) {
            return new Collection;
        }

        return Entity::select('id', 'name', 'entity_id')
            ->with('entityType')
            ->templates($entityType->id)
            ->orderBy('name')
            ->get();
    }

    public function api(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->entityType = $entityType;
        $this->campaign = $campaign;
        $this->request = $request;

        $this->filterService->request($request)->entityType($entityType)->campaign($campaign)->build(
            $this->columnDefinitionService->sortableFields($entityType, $campaign)
        );

        // Column definitions
        $columns = $this->columnDefinitionService->columns($entityType, $campaign);
        $relations = $this->columnDefinitionService->relationMap($entityType, $campaign);
        $childCountRelations = $this->columnDefinitionService->childCountRelations($entityType, $campaign);
        $entityCountRelations = $this->columnDefinitionService->entityCountRelations($entityType, $campaign);

        // User preferences (query once, reuse in isNested/layoutMode)
        $this->preference = null;
        if (auth()->check()) {
            $this->preference = EntityListingPreference::query()->where([
                'user_id' => auth()->id(),
                'campaign_id' => $campaign->id,
                'type_id' => $entityType->id,
            ])->first();
        }
        $preference = $this->preference;
        $columnPreferences = $preference->visible_columns
            ?? $this->columnDefinitionService->defaultVisibleColumns($entityType, $campaign);

        // Tell the resource which columns to serialize
        ExploreResource::withColumns(array_map(fn ($c) => $c['key'], $columns));

        $nested = $this->isNested();
        $layout = $this->layoutMode();

        $with = $relations;
        // Eager load child model with withCount for count columns (e.g. organisation.members)
        if ($entityType->isStandard()) {
            $childRelation = Str::camel($entityType->code);
            $with[$childRelation] = function ($query) use ($childCountRelations) {
                if (! empty($childCountRelations)) {
                    $query->withCount($childCountRelations);
                }
            };
        }
        // All entity types: nesting uses entities.parent_id
        $with['children'] = fn ($q) => $q->whereNull('archived_at')->with('image');

        $base = Entity::inTypes($entityType->id)
            ->select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private', 'entities.entity_id',
                'entities.type_id', 'entities.parent_id', 'entities.status_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y', 'entities.image_path',
            ])
            ->with($with)
            ->withCount(array_merge(
                ['children' => fn ($q) => $q->whereNull('archived_at')],
                $entityCountRelations,
            ))
            ->search($this->filterService->search())
            ->order($this->filterService->order(), $entityType)
            ->distinct();

        $parent = null;
        if ($request->has('parent_id')) {
            $parent = Entity::select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id', 'entities.entity_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y',
            ])
                ->inTypes([$entityType->id])->where('id', $request->get('parent_id'))->first();
            if ($parent) {
                $base->where('entities.parent_id', $request->get('parent_id'));
            }
        }
        if (empty($parent) && $nested && $this->filterService->activeFiltersCount() === 0) {
            $base->whereNull('entities.parent_id');
        }

        $unfilteredCount = 0;
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            $base = $base->filter($this->filterService->filters(), $entityType);
        } else {
            $base = $base->whereNull('entities.archived_at');
        }
        $perPage = $this->perPageValue();
        $models = $base->orderBy('entities.name')->paginate($perPage);

        // All children share the same entity type — set it without an extra DB query
        $models->each(function (Entity $entity) use ($entityType): void {
            $entity->children->each(fn (Entity $child) => $child->setRelation('entityType', $entityType));
        });

        $i18n = [
            'fields' => [
                'name' => __('crud.fields.name'),
                'type' => __('crud.fields.type'),
                'is_private' => __('crud.fields.is_private'),
            ],
            'is_private' => __('crud.is_private'),
            'select' => __('crud.select'),
            'selected' => __('datagrids.bulks.selected'),
            'selectAll' => __('general.select_all'),
            'done' => __('general.done'),
            'filters' => __('datagrids.actions.filters'),
            'bookmark' => __('filters.actions.bookmark'),
            'noResults' => __('search.no_results'),
            'templates' => __('entries/archetypes.helpers.how'),
            'actions' => __('crud.actions.actions'),
            'display' => __('datagrids.display.title'),
            'perPage' => __('datagrids.display.per_page'),
            'sortBy' => __('datagrids.display.sort_by'),
            'clearFilters' => __('datagrids.filters.clear'),
            'flatten' => __('datagrids.modes.flatten'),
            'nest' => __('datagrids.modes.nested'),
            'layout_grid' => __('datagrids.modes.grid'),
            'layout_table' => __('datagrids.modes.table'),
            'bulkEdit' => __('crud.bulk.actions.edit'),
            'bulkRemove' => __('crud.remove'),
            'bulkPermissions' => __('crud.bulk.actions.permissions'),
            'bulkTemplate' => __('crud.bulk.actions.kits'),
            'bulkTransform' => __('crud.actions.transform'),
            'bulkCopy' => __('crud.actions.copy_to_campaign'),
            'bulkPrint' => __('crud.actions.print'),
            'bulkDelete' => __('crud.remove'),
            'columns' => __('datagrids.columns.title'),
            'resetDefaults' => __('datagrids.columns.reset'),
            'relations' => __('entries/tabs.relations'),
            'inventory' => __('crud.tabs.inventory'),
            'edit' => __('crud.edit'),
        ];

        $bookmarkable = $this->filterService->activeFiltersCount() > 0 && auth()->check() && auth()->user()->can('create', Bookmark::class) && ! $request->has('bookmark');

        return response()->json([
            'parent' => $parent ? new ExploreResource($parent) : null,
            'entities' => ExploreResource::collection($models)->response()->getData(true),
            'nested' => $nested,
            'i18n' => $i18n,
            'bookmarkable' => $bookmarkable,
            'entityType' => new EntityTypeResource($entityType),
            'templates' => TemplateResource::collection($this->loadTemplates($campaign, $entityType)),
            'permissions' => auth()->check() ? [
                'create' => auth()->user()->can('create', [$entityType, $campaign]),
                'delete' => auth()->user()->can('deleteEntities', [$entityType, $campaign]),
                'template' => auth()->user()->can('useTemplates', $campaign),
                'admin' => auth()->user()->isAdmin($campaign),
            ] : null,
            'features' => [
                'inventories' => $campaign->enabled('inventories'),
            ],
            'urls' => [
                'create' => $entityType->createRoute($campaign),
                'batch' => route('bulk.batch', [$campaign, $entityType]),
                'template' => route('bulk.templates', [$campaign, $entityType]),
                'transform' => route('bulk.transform', [$campaign, $entityType]),
                'permissions' => route('bulk.permissions', [$campaign, $entityType]),
                'copy' => route('bulk.copy-to-campaign', [$campaign, $entityType]),
                'delete' => route('bulk.delete', [$campaign, $entityType]),
                'print' => route('bulk.print', [$campaign, $entityType]),
                'bookmark' => route('filters.modal_form', [$campaign, $entityType]),
                'preferences' => route('entities.listing-preferences.update', [$campaign, $entityType]),
                'preferencesReset' => route('entities.listing-preferences.destroy', [$campaign, $entityType]),
            ],
            'csrf' => csrf_token(),
            'filters' => [
                'count' => $this->filterService->activeFiltersCount(),
                'unfilteredCount' => $unfilteredCount,
                'urls' => [
                    'form' => route('filters.form', array_merge(
                        [$campaign, $entityType, 'm' => $layout],
                        $request->get('_from') === 'bookmark' ? ['_from' => 'bookmark', 'bookmark' => $request->get('bookmark')] : [],
                    )),
                    'clear' => route('entities.index', array_merge(
                        [$campaign, $entityType, 'reset-filter' => true],
                        $request->get('_from') === 'bookmark' ? ['_from' => 'bookmark', 'bookmark' => $request->get('bookmark')] : [],
                    )),
                ],
            ],
            'order' => $this->filterService->order(),
            'columns' => $columns,
            'columnPreferences' => $columnPreferences,
            'ads' => [
                'enabled' => $this->showAds($campaign),
                'frequency' => 7,
            ],
            'preferences' => $preference ? [
                'layout' => $preference->layout,
                'nested' => $preference->nested,
                'per_page' => $perPage,
            ] : null,
            'subscription' => [
                'isSubscriber' => auth()->check() && auth()->user()->isSubscriber(),
                'url' => route('datagrids.subscription'),
            ],
            'perPageOptions' => $this->paginationService->options(),
            'subscriberPerPageOptions' => $this->paginationService->subscriberOnlyOptions(),
            'emptyState' => [
                'title' => __('lists.empty.title', ['plural' => strtolower($entityType->plural())]),
                'helper' => __($entityType->pluralCode() . '.lists.empty'),
                'docsUrl' => 'https://docs.kanka.io/en/latest/entries/' . Str::replace('_', '-', $entityType->isAttributeTemplate() ? 'property-kits' : $entityType->pluralCode()) . '.html',
                'publicUrl' => Domain::toFront('campaigns'),
                'learn' => __('lists.actions.learn'),
                'public' => __('lists.actions.public'),
            ],
        ]);
    }

    protected function showAds(Campaign $campaign): bool
    {
        if (! config('ads.nitro.enabled')) {
            return false;
        }
        if (request()->has('_showads')) {
            return true;
        }
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->isSubscriber()) {
                return false;
            }
            if ($user->created_at->diffInHours(now()) < 24) {
                return false;
            }
        }

        return ! $campaign->boosted();
    }

    /**
     * Determine if the current layout should be nested or not
     */
    protected function isNested(): bool
    {
        if (! $this->entityType->isNested()) {
            return false;
        }

        $key = $this->entityType->code . '_nested';

        // URL override
        if ($this->request->has('n')) {
            return $this->saveNested($key);
        }

        // Check preferences table
        if ($this->preference && $this->preference->nested !== null) {
            return $this->preference->nested;
        }

        // Fallback to session for guests
        if (auth()->guest()) {
            return (bool) Session::get($key, true);
        }

        return true;
    }

    /**
     * Determine if the current layout should be grid or table
     */
    protected function layoutMode(): string
    {
        $key = $this->entityType->code . '_layout';

        if ($this->request->has('m') && in_array($this->request->get('m'), ['grid', 'table'])) {
            $new = $this->request->get('m', 'grid');

            if (auth()->guest()) {
                Session::put($key, $new);
            } else {
                $settings = auth()->user()->settings;
                if (auth()->check() && Arr::get($settings, $key) != $new) {
                    $settings = auth()->user()->settings;
                    if ($new === 'grid') {
                        unset($settings[$key]);
                    } else {
                        $settings[$key] = 'table';
                    }
                    auth()->user()->settings = $settings;
                    auth()->user()->updateQuietly();
                }
            }

            return $new;
        }

        // Check preferences table
        if ($this->preference && $this->preference->layout !== null) {
            return $this->preference->layout;
        }

        if (auth()->guest()) {
            return Session::get($key, 'grid');
        }

        return Arr::get(auth()->user()->settings, $key, 'grid');
    }

    protected function perPageValue(): int
    {
        $allowed = $this->paginationService->options();
        $subscriberOnly = $this->paginationService->subscriberOnlyOptions();
        $isSubscriber = auth()->user()?->isSubscriber() ?? false;
        $default = 25;

        $cap = function (int $value) use ($subscriberOnly, $isSubscriber, $default): int {
            if (in_array($value, $subscriberOnly) && ! $isSubscriber) {
                return $default;
            }

            return $value;
        };

        // URL override (e.g. from pagination links)
        if ($this->request->has('pp')) {
            $pp = (int) $this->request->get('pp');
            if (in_array($pp, $allowed)) {
                return $cap($pp);
            }
        }

        // Preference
        if ($this->preference && in_array($this->preference->per_page, $allowed)) {
            return $cap($this->preference->per_page);
        }

        return $default;
    }
}
