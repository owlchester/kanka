<?php

namespace App\Services\Api;

use App\Facades\CampaignCache;
use App\Http\Resources\Public\CampaignResource;
use App\Models\Campaign;
use App\Services\GenreService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
                ]
            ],
            'system' => [
                'title' => 'System',
                'options' => CampaignCache::systems()
            ],
            'is_boosted' => [
                'title' => 'Premium campaigns',
                'options' => [
                    '1' => 'Only premium campaigns',
                ]
            ],
            'is_open' => [
                'title' => 'Open campaigns',
                'options' => [
                    '1' => 'Only open campaigns',
                ]
            ],
            'genre' => [
                'title' => 'Genre',
                'options' => $this->genreService->getGenres()
            ],
        ];
        return $this;
    }

    protected function featured(): self
    {

        $this->data['featured'] = [];
        $campaigns = Campaign::public()->front()->featured()->get();
        foreach ($campaigns as $campaign) {
            $this->data['featured'][] = new CampaignResource($campaign);
        }
        return $this;
    }

    protected function campaigns(): self
    {
        $this->data['campaigns'] = [];
        $campaigns = Campaign::public()
            ->front((int) $this->request->get('sort_field_name'))
            ->featured(false)
            ->filterPublic($this->request->only(['language', 'system', 'is_boosted', 'is_open', 'genre']))
            ->paginate();
        $this->data['campaigns'] = CampaignResource::collection($campaigns);

        $this->campaignsMeta();

        return $this;
    }

    protected function campaignsMeta(): void
    {
        /** @var $paginator LengthAwarePaginator */
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
