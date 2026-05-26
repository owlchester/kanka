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
