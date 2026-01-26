<?php

namespace App\Services\Api;

use App\Http\Resources\Public\CampaignResource;
use App\Models\Campaign;
use App\Services\GenreService;
use App\Traits\RequestAware;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ShowcaseService
{
    use RequestAware;

    protected array $data = [];

    public function __construct(protected GenreService $genreService) {}

    public function search(): array
    {
        return $this->campaigns()
            ->data;
    }

    /**
     * Build a list of public campaigns
     */
    protected function campaigns(): self
    {
        $this->data['campaigns'] = [];

        if ($this->usesDefaultFilters() && ! app()->hasDebugModeEnabled()) {
            $this->data['campaigns'] = $this->cachedCampaigns();
        } else {
            $campaigns = $this->baseQuery()
                ->paginate();
            $this->data['campaigns'] = CampaignResource::collection($campaigns);
        }

        $this->campaignsMeta();

        return $this;
    }

    /**
     * Determine if the request comes with any filters
     */
    protected function usesDefaultFilters(): bool
    {
        return ! $this->request->anyFilled('page');
    }

    /**
     * Cache the first page of campaigns with no filters for a day
     */
    protected function cachedCampaigns(int $hours = 24): AnonymousResourceCollection
    {
        return Cache::remember('showcase-campaigns-page-1', $hours * 3600, function () {
            $campaigns = $this
                ->baseQuery()
                ->paginate();

            return CampaignResource::collection($campaigns);
        });
    }

    protected function baseQuery(): Builder
    {
        return Campaign::public(false)
            ->showcased(null)
            ->with(['systems', 'spotlight']);
    }

    /**
     * Add some pagination data to the response
     */
    protected function campaignsMeta(): void
    {
        /** @var LengthAwarePaginator $paginator */
        $paginator = $this->data['campaigns']->resource;
        $this->data['pagination'] = [
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'total' => $paginator->total(),
            'has_pages' => $paginator->hasPages(),
            'next' => $paginator->nextPageUrl(),
            'previous' => $paginator->previousPageUrl(),
        ];
    }
}
