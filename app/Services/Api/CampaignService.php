<?php

namespace App\Services\Api;

use App\Facades\CampaignCache;
use App\Http\Resources\Public\CampaignResource;
use App\Models\Campaign;
use App\Services\GenreService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CampaignService
{
    protected array $data = [];

    protected Request $request;

    protected GenreService $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setup(): array
    {
        $this->filters()
            ->featured();

        return $this->data;
    }

    public function search(): array
    {
        $this->campaigns();

        return $this->data;
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
                'options' => CampaignCache::systems(),
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

        $this->data['featured'] = [];
        $campaigns = Campaign::public()->front()->featured()->discreet(false)->get();
        foreach ($campaigns as $campaign) {
            $this->data['featured'][] = new CampaignResource($campaign);
        }

        return $this;
    }

    /**
     * Build a list of public campaigns
     */
    protected function campaigns(): self
    {
        $this->data['campaigns'] = [];

        if ($this->isDefaultRequest()) {
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
    protected function isDefaultRequest(): bool
    {
        return ! $this->request->anyFilled('sort_field_name', 'language', 'system', 'is_boosted', 'is_open', 'genre', 'page');
    }

    /**
     * Cache the first page of campaigns with no filters for a day
     */
    protected function cachedCampaigns(int $hours = 24): AnonymousResourceCollection
    {
        $cacheKey = 'public-campaigns-page-1';
        if (! app()->environment('testing') && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }
        $campaigns = Campaign::public()
            ->front()
            ->featured(false)
            ->filterPublic([])
            ->paginate();
        $cached = CampaignResource::collection($campaigns);

        Log::info('Create new cache', ['key' => $cacheKey, 'hours' => $hours]);
        cache()->put($cacheKey, $cached, $hours * 3600);

        return $cached;
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
}
