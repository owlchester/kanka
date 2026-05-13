<?php

namespace App\Services\Search;

use App\Services\SearchService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CommandSearchService
{
    use CampaignAware;
    use UserAware;

    public function __construct(
        protected SearchService $searchService,
        protected EntitySearchService $entitySearchService,
        protected AdminPageService $adminPageService,
    ) {}

    /**
     * Name mode: entity name search + matching admin/index pages.
     */
    public function name(string $term): array
    {
        $result = $this->searchService
            ->campaign($this->campaign)
            ->user($this->user)
            ->term($term)
            ->full()
            ->v2()
            ->limit(8)
            ->find();

        $entities = collect($result['entities'] ?? [])
            ->map(fn (array $entity) => array_merge($entity, [
                'log_url' => route('search.log', [$this->campaign, $entity['id']]),
            ]))
            ->values()
            ->toArray();

        return [
            'entities' => $entities,
            'pages' => $this->adminPageService->campaign($this->campaign)->match($term),
        ];
    }

    /**
     * Full-text mode: Meilisearch results with highlighted snippets.
     */
    public function fulltext(string $term): array
    {
        return [
            'results' => $this->entitySearchService
                ->campaign($this->campaign)
                ->searchWithSnippets($term),
        ];
    }
}
