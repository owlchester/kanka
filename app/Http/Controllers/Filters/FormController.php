<?php

namespace App\Http\Controllers\Filters;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Relation;
use App\Services\FilterService;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Exception;
use ReflectionClass;

class FormController extends Controller
{
    use CampaignAware;

    public function __construct(protected FilterService $filterService)
    {
        $this->middleware(['auth']);
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $plural = Str::plural(Str::remove('-', $entityType->code));
        $route = $plural . '.index';

        if ($entityType->isSpecial()) {
            $this->filterService->entityType($entityType)->build();
            return view('entities.index.filters')
                ->with('campaign', $campaign)
                ->with('entityType', $entityType)
                ->with('filterService', $this->filterService)
            ;
        }
        $model = $entityType->getClass();

        try {
            return $this->campaign($campaign)->render($model, $plural, $route, $entityType);
        } catch (Exception $e) {
            return redirect()->route('dashboard', $campaign);
        }
    }

    public function connection(Campaign $campaign)
    {
        $route = 'relations.index';
        $model = new Relation();
        $plural = 'relations';

        try {
            return $this->campaign($campaign)->render($model, $plural, $route, null, 'entities/relations');
        } catch (Exception $e) {
            return redirect()->route('dashboard', $campaign);
        }
    }

    protected function render(mixed $model, string $plural, string $route, ?EntityType $entityType = null, ?string $langKey = null)
    {
        $this->filterService
            ->model($model)
            ->make($plural);
        $mode = request()->get('m');

        $reflect = new ReflectionClass($model);
        $filtersClass = 'App\Datagrids\Filters\\' . $reflect->getShortName() . 'Filter';
        $filters = app()->make($filtersClass);
        if ($filters) {
            $filters->campaign($this->campaign)->build();
        }

        return view('filters.form')
            ->with('campaign', $this->campaign)
            ->with('filters', $filters->filters())
            ->with('filterService', $this->filterService)
            ->with('route', $route)
            ->with('entityModel', $model)
            ->with('entityType', $entityType)
            ->with('count', 0)
            ->with('langKey', $langKey ?? $plural)
            ->with('hasAttributeFilters', false)
            ->with('activeFilters', $this->filterService->activeFiltersCount())
            ->with('clipboardFilters', $this->filterService->clipboardFilters())
            ->with('mode', $mode);
    }
}
