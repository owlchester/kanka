<?php

namespace App\Services\Api;

use App\Http\Resources\Public\CampaignResource;
use App\Models\Campaign;
use App\Models\GameSystem;
use App\Services\GenreService;
use App\Traits\RequestAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CampaignService
{
    use RequestAware;

    protected array $data = [];

    public function __construct(protected GenreService $genreService) {}

    public function setup(): array
    {
        return $this->filters()
            ->featured()
            ->data;
    }

    public function search(): array
    {
        return $this->campaigns()
            ->data;
    }

    protected function filters(): self
    {
        $this->data['filters'] = [
            'language' => [
                'title' => 'Language',
                'options' => [
                    'en' => 'English',
                    'pt-BR' => 'Brazilian Portuguese',
                    'fr' => 'French',
                    'de' => 'German',
                    'es' => 'Spanish',
                    'ru' => 'Russian',
                    'it' => 'Italian',
                    'pl' => 'Polish',
                    'sk' => 'Slovak',
                ],
            ],
            'system[]' => [
                'title' => 'System',
                'options' => $this->systemsOptions(),
            ],
            'is_boosted' => [
                'title' => 'Premium campaigns',
                'options' => [
                    '1' => 'Only premium campaigns',
                ],
            ],
            'is_open' => [
                'title' => 'Open campaigns',
                'options' => [
                    '1' => 'Only open campaigns',
                ],
            ],
            'genre' => [
                'title' => 'Genre',
                'options' => $this->genreService->getGenres(),
            ],
        ];

        return $this;
    }

    /**
     * Build a list of featured campaigns
     */
    protected function featured(): self
    {

        $this->data['featured'] = Campaign::public()
            ->front()
            ->featured()
            ->discreet(false)
            ->get()
            ->map(fn ($campaign) => new CampaignResource($campaign));

        return $this;
    }

    /**
     * Build a list of public campaigns
     */
    protected function campaigns(): self
    {
        $this->data['campaigns'] = [];

        if ($this->usesDefaultFilters()) {
            $this->data['campaigns'] = $this->cachedCampaigns();
        } else {
            $campaigns = Campaign::public()
                ->front((int) $this->request->get('sort_field_name'))
                ->featured(false)
                ->filterPublic($this->request->only(['language', 'system', 'is_boosted', 'is_open', 'genre']))
                ->discreet(false)
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
        return ! $this->request->anyFilled('sort_field_name', 'language', 'system', 'is_boosted', 'is_open', 'genre', 'page');
    }

    /**
     * Cache the first page of campaigns with no filters for a day
     */
    protected function cachedCampaigns(int $hours = 24): AnonymousResourceCollection
    {
        return Cache::remember('public-campaigns-page-1', 24 * 3600, function () {
            $campaigns = Campaign::public()
                ->front()
                ->featured(false)
                ->filterPublic([])
                ->paginate();

            return CampaignResource::collection($campaigns);
        });
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
            'total_pages' => $paginator->total(),
            'next' => $paginator->nextPageUrl(),
            'previous' => $paginator->previousPageUrl(),
        ];
    }

    protected function systemsOptions(): array
    {
        return Cache::remember('campaign_systems', 24 * 3600, function () {
            return GameSystem::withCount('campaignSystem')
                ->orderByDesc('campaign_system_count')
                ->limit(20)
                ->pluck('name', 'id')
                ->toArray();
        });
    }
}
