<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Meilisearch\Client;
use Meilisearch\Contracts\SearchQuery;

class EntitySearchService
{
    use CampaignAware;

    protected array $ids = [];

    protected array $attributeIds = [];

    protected array $timelineElementIds = [];

    protected array $postIds = [];

    protected array $questElementIds = [];

    protected int $limit = 10;

    protected int $pages;

    protected int $page = 1;

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function pages(): int
    {
        return $this->pages;
    }

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Send search request
     */
    public function search(?string $term = null, ?string $term2 = null): array
    {
        // Get results from Meilisearch
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();
        $queries = [
            (new SearchQuery)
                ->setIndexUid('entities')
                ->setQuery($term)
                ->setFilter(['campaign_id = ' . $this->campaign->id])
                ->setAttributesToRetrieve(['id', 'entity_id', 'type'])
                ->setPage($this->page)
                ->setLimit($this->limit)
                ->setHitsPerPage($this->limit),
        ];

        if ($term2) {
            $queries[] =
                (new SearchQuery)
                    ->setIndexUid('entities')
                    ->setQuery($term2)
                    ->setFilter(['campaign_id = ' . $this->campaign->id])
                    ->setAttributesToRetrieve(['id', 'entity_id', 'type'])
                    ->setPage($this->page)
                    ->setLimit($this->limit)
                    ->setHitsPerPage($this->limit);
        }
        $results = $client->multiSearch($queries);

        if ($term2) {
            $entities = array_merge($results['results'][0]['hits'], $results['results'][1]['hits']);
        } else {
            $entities = $results['results'][0]['hits'];
        }

        $this->pages = $results['results'][0]['totalPages'];

        return $this->process($entities)->fetch();
    }

    /**
     * Search with Meilisearch snippets for the command center full-text mode.
     * Returns up to 20 results with a highlighted excerpt from the entry field.
     */
    public function searchWithSnippets(string $term, ?string $term2 = null): array
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();

        $baseQuery = fn (string $q) => (new SearchQuery)
            ->setIndexUid('entities')
            ->setQuery($q)
            ->setFilter(['campaign_id = ' . $this->campaign->id])
            ->setAttributesToRetrieve(['id', 'entity_id', 'type'])
            ->setAttributesToHighlight(['name', 'entry'])
            ->setAttributesToCrop(['entry'])
            ->setCropLength(20)
            ->setHighlightPreTag('<mark>')
            ->setHighlightPostTag('</mark>')
            ->setLimit(20);

        $queries = [$baseQuery($term)];
        if ($term2) {
            $queries[] = $baseQuery($term2);
        }

        $results = $client->multiSearch($queries);
        $hits = $results['results'][0]['hits'] ?? [];
        if ($term2) {
            $hits = array_merge($hits, $results['results'][1]['hits'] ?? []);
        }

        if (empty($hits)) {
            return [];
        }

        $entityIds = array_column($hits, 'entity_id');
        $entities = Entity::select(['id', 'name', 'is_private', 'type_id'])
            ->with(['image', 'entityType'])
            ->whereIn('id', $entityIds)
            ->get()
            ->keyBy('id');

        $output = [];
        foreach ($hits as $hit) {
            $entity = $entities->get($hit['entity_id']);
            if (! $entity) {
                continue;
            }

            $rawSnippet = $hit['_formatted']['entry'] ?? '';
            $snippet = strip_tags($rawSnippet, '<mark>');
            if (! empty($snippet)) {
                $snippet = trim($snippet);
            }

            $output[] = [
                'id' => $entity->id,
                'name' => $entity->name,
                'is_private' => $entity->is_private,
                'image' => Avatar::entity($entity)->fallback()->size(64)->thumbnail(),
                'link' => $entity->url(),
                'type' => $entity->entityType->name() ?? '',
                'icon' => $entity->entityType->icon() ?? '',
                'snippet' => $snippet,
                'log_url' => route('search.log', [$this->campaign, $entity->id]),
            ];
        }

        return $output;
    }

    /**
     * Process results to fetch entities from db
     *
     * @param  array  $results  Search term
     */
    protected function process(array $results = []): self
    {
        foreach ($results as $result) {
            if ($result['type'] == 'quest_element') {
                $id = Str::afterLast($result['id'], '_');
                $this->questElementIds[$result['entity_id']] = $id;
                // dd($result);
            } elseif ($result['type'] == 'timeline_element') {
                $id = Str::afterLast($result['id'], '_');
                $this->timelineElementIds[$result['entity_id']] = $id;
                // dd($result);
            } elseif ($result['type'] == 'post') {
                $id = Str::afterLast($result['id'], '_');
                $this->postIds[$result['entity_id']] = $id;
                // dd($result);
            } elseif ($result['type'] == 'attribute') {
                $id = Str::afterLast($result['id'], '_');
                $this->attributeIds[$result['entity_id']] = $id;
                // dd($result);
            } else {
                $this->ids[$result['entity_id']] = $result['entity_id'];
            }
        }

        // If the search also threw the entity as a possible result don't bother loading the other models
        $this->attributeIds = array_diff_key($this->attributeIds, $this->ids);
        $this->timelineElementIds = array_diff_key($this->timelineElementIds, $this->ids);
        $this->questElementIds = array_diff_key($this->questElementIds, $this->ids);
        $this->postIds = array_diff_key($this->postIds, $this->ids);

        return $this;
    }

    /**
     * Fetch entities from DB
     */
    protected function fetch(): array
    {
        $posts = Post::select(['id', 'entity_id'])
            ->with('entity')
            ->has('entity')
            ->whereIn('id', $this->postIds)
            ->get();
        $attributes = Attribute::select(['id', 'entity_id'])
            ->with('entity')
            ->has('entity')
            ->whereIn('id', $this->attributeIds)
            ->get();
        $questElements = QuestElement::select(['id', 'quest_id'])
            ->with(['quest', 'quest.entity'])
            ->has('quest.entity')
            ->whereIn('id', $this->questElementIds)
            ->get();
        $timelineElements = TimelineElement::select(['id', 'timeline_id'])
            ->with(['timeline', 'timeline.entity'])
            ->has('timeline.entity')
            ->whereIn('id', $this->timelineElementIds)
            ->get();

        // Get entities from db
        $entities = Entity::select('id', 'name')
            ->whereIn('id', $this->ids)
            ->orderBy('name')
            ->get();

        // Process entities for output
        $output = [];
        foreach ($entities as $entity) {
            $output[$entity->id] = [
                'id' => $entity->id,
                'entity' => $entity->name,
                'url' => $entity->url(),
            ];
        }
        foreach ($attributes as $attribute) {
            $output[$attribute->entity->id] = [
                'id' => $attribute->entity->id,
                'entity' => $attribute->entity->name,
                'url' => $attribute->entity->url(),
            ];
        }
        foreach ($posts as $post) {
            $output[$post->entity->id] = [
                'id' => $post->entity->id,
                'entity' => $post->entity->name,
                'url' => $post->entity->url(),
            ];
        }
        foreach ($questElements as $questElement) {
            $output[$questElement->quest->entity->id] = [
                'id' => $questElement->quest->entity->id,
                'entity' => $questElement->quest->name,
                'url' => $questElement->quest->entity->url(),
            ];
        }
        foreach ($timelineElements as $timelineElement) {
            $output[$timelineElement->timeline->entity->id] = [
                'id' => $timelineElement->timeline->entity->id,
                'entity' => $timelineElement->timeline->entity->name,
                'url' => $timelineElement->timeline->entity->url(),
            ];
        }

        return $output;
    }
}
