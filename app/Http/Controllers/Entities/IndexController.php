<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IndexController extends Controller
{
    public function __construct(protected FilterService $filterService)
    {

    }
    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->filterService->request($request)->entityType($entityType)->build();

        $base = Entity::inTypes($entityType->id)
            ->select(['entities.*'])
            ->with(['entityType', 'image'])
            ->search($this->filterService->search())
            ->order($this->filterService->order())
            ->distinct()
        ;

        $unfilteredCount = 0;
        if ($this->filterService->hasFilters()) {
            $unfilteredCount = $base->count();
            // @phpstan-ignore-next-line
            $base = $base->filter($this->filterService->filters());
        }
        $models = $base->paginate();

        return view('entities.index.index')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('models', $models)
            ->with('mode', 'grid')
            ->with('forceMode', 'grid')
            ->with('filterService', $this->filterService)
            ->with('nestable', false)
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
}
