<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Entities\ExploreResource;
use App\Http\Resources\Entities\TemplateResource;
use App\Http\Resources\EntityTypeResource;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\FilterService;
use App\Traits\Controllers\HasNested;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    use HasNested;

    protected EntityType $entityType;

    protected Request $request;

    public function __construct(
        protected FilterService $filterService
    ) {}

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        if (! $entityType->isEnabled()) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns/modules.errors.disabled', [
                    'name' => $entityType->plural(),
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#' . $entityType->code]) . '">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        // If not a special entity type, redirect to their "old" route
        if ($entityType->isStandard()) {
            return redirect()->route($entityType->pluralCode() . '.index', $campaign);
        }

        $this->entityType = $entityType;
        $this->request = $request;

        $this->filterService->request($request)->entityType($entityType)->build();

        $nested = $this->isNested();
        $mode = $this->layoutMode();
        $title = $entityType->plural();

        $parent = null;
        if ($request->has('parent_id')) {
            $parent = Entity::select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id',
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
            ->templates($entityType->id)
            ->orderBy('name')
            ->get();
    }

    public function api(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->entityType = $entityType;
        $this->request = $request;

        $this->filterService->request($request)->entityType($entityType)->build();

        $nested = $this->isNested();
        $layout = $this->layoutMode();

        $with = ['entityType', 'image'];
        if ($this->entityType->isStandard()) {
            $with[] = $this->entityType->code;
        }
        $base = Entity::inTypes($entityType->id)
            ->select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private', 'entities.entity_id',
                'entities.type_id', 'entities.parent_id',
                'entities.image_uuid', 'entities.focus_x', 'entities.focus_y', 'entities.image_path',
            ])
            ->with($with)
            ->withCount('children')
            ->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct();

        $parent = null;
        if ($request->has('parent_id')) {
            $parent = Entity::select([
                'entities.id', 'entities.name', 'entities.type', 'entities.is_private',
                'entities.type_id', 'entities.parent_id',
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
            $base = $base->filter($this->filterService->filters());
        } else {
            $base = $base->whereNull('archived_at');
        }
        $models = $base->orderBy('name')->paginate();

        $i18n = [
            'fields' => [
                'name' => __('crud.fields.name'),
                'type' => __('crud.fields.type'),
                'is_private' => __('crud.fields.is_private'),
            ],
            'is_private' => __('crud.is_private'),
            'select' => __('crud.select'),
            'selectAll' => __('general.select_all'),
            'done' => __('general.done'),
            'filters' => __('crud.filters.title'),
            'bookmark' => __('filters.actions.bookmark'),
            'noResults' => __('search.no_results'),
            'templates' => __('helpers.entity_templates.link'),
            'actions' => __('crud.actions.actions'),
            'flatten' => __('datagrids.modes.flatten'),
            'nest' => __('datagrids.modes.nested'),
            'layout_grid' => __('datagrids.modes.grid'),
            'layout_table' => __('datagrids.modes.table'),
            'bulkEdit' => __('crud.bulk.actions.edit'),
            'bulkRemove' => __('crud.remove'),
            'bulkPermissions' => __('crud.bulk.actions.permissions'),
            'bulkTemplate' => __('crud.bulk.actions.templates'),
            'bulkTransform' => __('crud.actions.transform'),
            'bulkCopy' => __('crud.actions.copy_to_campaign'),
            'bulkPrint' => __('crud.actions.print'),
            'bulkDelete' => __('crud.remove'),
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
            ],
            'csrf' => csrf_token(),
            'filters' => [
                'count' => $this->filterService->activeFiltersCount(),
                'unfilteredCount' => $unfilteredCount,
                'urls' => [
                    'form' => route('filters.form', [$campaign, $entityType, 'm' => 'grid']),
                    'clear' => route('entities.index', [$campaign, $entityType, 'reset-filter' => true]),
                ],
            ],
            'order' => $this->filterService->order(),
        ]);
    }

    /**
     * Determine if the current layout should be nested or not
     */
    protected function isNested(): bool
    {
        $key = $this->entityType->code . '_nested';
        if ($this->request->has('n')) {
            return $this->saveNested($key);
        }

        if (auth()->guest()) {
            return (bool) Session::get($key, true);
        }

        // Else use the user's preferred stacking for this entity type
        return Arr::get(auth()->user()->settings, $key, true);
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

        if (auth()->guest()) {
            return Session::get($key, 'grid');
        }

        // Else use the user's preferred stacking for this entity type
        return Arr::get(auth()->user()->settings, $key, 'grid');
    }
}
