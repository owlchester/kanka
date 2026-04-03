<?php

namespace App\Http\Controllers\Filters;

use App\Datagrids\Filters\CharacterFilter;
use App\Datagrids\Filters\CustomEntityFilter;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Relation;
use App\Services\FilterService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ReflectionClass;

class FormController extends Controller
{
    use CampaignAware;
    use EntityTypeAware;

    public function __construct(protected FilterService $filterService)
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('access', $campaign);

        $plural = Str::plural(Str::remove('-', $entityType->code));
        $route = $entityType->hasEntity() ? 'entities.index' : $plural . '.index';
        $this->entityType($entityType);

        if ($entityType->isCustom()) {
            $this->filterService
                ->request($request)
                ->entityType($entityType)
                ->campaign($campaign)
                ->build();

            /** @var CustomEntityFilter $filters */
            $filters = app()->make(CustomEntityFilter::class);
            $filters->campaign($campaign)->entityType($entityType)->build();

            return view('filters.form')
                ->with('filters', $filters->filters())
                ->with('campaign', $campaign)
                ->with('entityType', $entityType)
                ->with('filterService', $this->filterService);
        }
        $model = $entityType->getClass();

        try {
            return $this->campaign($campaign)->render($model, $plural, $route);
        } catch (Exception $e) {
            if (app()->hasDebugModeEnabled()) {
                throw $e;
            }

            return redirect()->route('dashboard', $campaign);
        }
    }

    public function connection(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $route = 'relations.index';
        $model = new Relation;
        $plural = 'relations';

        try {
            return $this->campaign($campaign)->render($model, $plural, $route, 'entities/relations');
        } catch (Exception $e) {
            return redirect()->route('dashboard', $campaign);
        }
    }

    protected function render(mixed $model, string $plural, string $route, ?string $langKey = null)
    {
        if (isset($this->entityType)) {
            $this->filterService
                ->entityType($this->entityType)
                ->campaign($this->campaign)
                ->build();
        } else {
            $this->filterService
                ->campaign($this->campaign)
                ->model($model)
                ->make($plural);
        }
        $mode = request()->get('m');

        $reflect = new ReflectionClass($model);
        $filtersClass = 'App\Datagrids\Filters\\' . $reflect->getShortName() . 'Filter';
        /** @var CharacterFilter $filters */
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
            ->with('entityType', $this->entityType ?? null)
            ->with('count', 0)
            ->with('langKey', $langKey ?? $plural)
            ->with('hasAttributeFilters', false)
            ->with('activeFilters', $this->filterService->activeFiltersCount())
            ->with('clipboardFilters', $this->filterService->clipboardFilters())
            ->with('mode', $mode);
    }
}
