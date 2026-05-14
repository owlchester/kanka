<?php

namespace App\Services\Search;

use App\Models\Entity;
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
     * Name mode: entity name search + mention search via Meilisearch.
     * Follows the same pattern as FullTextController: if the term matches an entity
     * exactly, also search for its mention code so we find everywhere it is referenced.
     */
    public function name(string $term): array
    {
        $meiliResults = $this->entitySearchService
            ->campaign($this->campaign)
            ->limit(20)
            ->search($term);

        $meiliEntityIds = array_column(array_values($meiliResults), 'id');

        $this->searchService
            ->campaign($this->campaign)
            ->user($this->user);

        $formatted = Entity::with(['image', 'entityType'])
            ->whereIn('id', $meiliEntityIds)
            ->get()
            ->map(fn (Entity $e) => array_merge(
                $this->searchService->formatForLookup($e),
                ['log_url' => route('search.log', [$this->campaign, $e->id])]
            ))
            ->values()
            ->toArray();

        return [
            'entities' => $formatted,
            'pages' => $this->adminPageService->campaign($this->campaign)->match($term),
        ];
    }

    /**
     * Full-text mode: Meilisearch results with highlighted snippets.
     */
    public function fulltext(string $term): array
    {
        $term2 = null;
        $entity = Entity::with('entityType')
            ->where('campaign_id', $this->campaign->id)
            ->where('name', $term)
            ->first();
        if ($entity) {
            $term2 = $entity->entityType->code . ':' . $entity->id;
        }

        return [
            'results' => $this->entitySearchService
                ->campaign($this->campaign)
                ->searchWithSnippets($term, $term2),
        ];
    }
}
