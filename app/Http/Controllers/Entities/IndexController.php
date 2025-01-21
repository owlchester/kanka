<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    protected EntityType $entityType;
    protected Request $request;


    public function __construct(
        protected FilterService $filterService
    ) {

    }
    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {

        if (!$entityType->isEnabled()) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns/modules.errors.disabled', [
                    'name' => $entityType->plural(),
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#' . $entityType->code]) . '">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }

        $this->entityType = $entityType;
        $this->request = $request;

        $this->filterService->request($request)->entityType($entityType)->build();

        $nested = $this->isNested();

        $base = Entity::inTypes($entityType->id)
            ->select(['entities.*'])
            ->with(['entityType', 'image', 'children'])
            ->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct()
        ;

        $parent = null;
        if (request()->has('parent_id')) {
            $parent = Entity::inTypes([$entityType->id])->where('id', request()->get('parent_id'))->first();
            if ($parent) {
                $base->where('entities.parent_id', request()->get('parent_id'));
            }
        }
        if (empty($parent) && $nested && $this->filterService->activeFiltersCount() === 0) {
            // @phpstan-ignore-next-line
            $base->whereNull('entities.parent_id');
        }

        $unfilteredCount = 0;
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            $base = $base->filter($this->filterService->filters());
        }
        $models = $base->orderBy('name')->paginate();

        return view('entities.index.index')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('models', $models)
            ->with('mode', 'grid')
            ->with('parent', $parent)
            ->with('forceMode', 'grid')
            ->with('filterService', $this->filterService)
            ->with('nestable', $nested)
            ->with('unfilteredCount', $unfilteredCount)
            ->with('templates', $this->loadTemplates($campaign, $entityType))
        ;
    }


    protected function loadTemplates(Campaign $campaign, EntityType $entityType): Collection
    {
        // No valid user, or invalid entity type (ie relations)
        if (auth()->guest()) {
            return new Collection();
        } elseif (!auth()->user()->can('create', [$entityType, $campaign])) {
            return new Collection();
        }
        return Entity::select('id', 'name', 'entity_id')
            ->templates($entityType->id)
            ->orderBy('name')
            ->get();
    }
    /**
     * Determine if the current layout should be nested or not
     */
    protected function isNested(): bool
    {
        $key = $this->entityType->code . '_nested';
        if ($this->request->has('n')) {
            $new = (bool) $this->request->get('n');
            if (auth()->guest()) {
                Session::put($key, $new);
            } else {
                $settings = auth()->user()->settings;
                if (auth()->check() && Arr::get($settings, $key) !== $new) {
                    $settings = auth()->user()->settings;
                    if ($new) {
                        unset($settings[$key]);
                    } else {
                        $settings[$key] = false;
                    }
                    auth()->user()->settings = $settings;
                    auth()->user()->updateQuietly();
                }
            }
            return $new;
        }

        if (auth()->guest()) {
            return (bool) Session::get($key, true);
        }
        // Else use the user's preferred stacking for this entity type
        return Arr::get(auth()->user()->settings, $key, true);
    }
}
