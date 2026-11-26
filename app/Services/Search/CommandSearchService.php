<?php

namespace App\Services\Search;

use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CommandSearchService
{
    use CampaignAware;
    use UserAware;

    public function __construct(
        protected NameLookupService $searchService,
        protected EntitySearchService $entitySearchService,
        protected AdminPageService $adminPageService,
    ) {}

    /**
     * Name mode: SQL name and alias lookup plus command pages.
     */
    public function name(string $term): array
    {
        if (isset($this->user)) {
            $this->searchService->user($this->user);
        }
        $result = $this->searchService
            ->campaign($this->campaign)
            ->term($term)
            ->full()
            ->v2(includePages: false)
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
        if (config('scout.search_maintenance', false)) {
            return ['results' => [], 'pages' => [], 'maintenance' => true, 'message' => __('search/fulltext.maintenance')];
        }
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
            'pages' => $this->adminPageService->campaign($this->campaign)->match($term),
            'maintenance' => false,
        ];
    }
}
