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

    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->middleware(['auth']);
        $this->filterService = $filterService;
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $plural = Str::plural(Str::remove('-', $entityType->code));
        $route = $plural . '.index';

        $model = $entityType->getClass();

        try {
            return $this->campaign($campaign)->render($model, $plural, $route);
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
            return $this->campaign($campaign)->render($model, $plural, $route, 'entities/relations');
        } catch (Exception $e) {
            return redirect()->route('dashboard', $campaign);
        }
    }

    protected function render(mixed $model, string $plural, string $route, ?string $langKey = null)
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
            ->with('count', 0)
            ->with('langKey', $langKey ?? $plural)
            ->with('hasAttributeFilters', false)
            ->with('activeFilters', $this->filterService->activeFiltersCount())
            ->with('clipboardFilters', $this->filterService->clipboardFilters())
            ->with('mode', $mode);
    }
}
