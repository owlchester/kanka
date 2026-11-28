<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;
use App\Models\User;
use App\Services\EntityTypeService;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;
use Meilisearch\Client;
use Meilisearch\Contracts\SearchQuery;
use Meilisearch\Exceptions\ExceptionInterface;

#[Description('Full-text search across visible entity descriptions, names, articles (posts), and properties in a campaign. Returns matching entities with plain-text excerpts.')]
#[IsReadOnly]
#[IsIdempotent]
class SearchContentTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context, EntityTypeService $entityTypes): ResponseFactory
    {
        $this->recordUsage();

        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'query' => ['required', 'string', 'min:1', 'max:100'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:30'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 401);

        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $query = (string) $arguments['query'];
        $limit = (int) ($arguments['limit'] ?? 15);
        $enabledEntityTypes = array_keys($entityTypes->campaign($campaign)->toSelect());

        if (config('scout.driver') === 'meilisearch' && ! config('scout.search_maintenance', false)) {
            try {
                $results = $this->searchMeilisearch($user, $campaign, $query, $limit, $enabledEntityTypes);

                return Response::structured([
                    'results' => $results,
                    'search_engine' => 'meilisearch',
                ]);
            } catch (ExceptionInterface) {
                // Fall back to database search if Meilisearch is unavailable
            }
        }

        return Response::structured([
            'results' => $this->searchDatabase($user, $campaign, $query, $limit, $enabledEntityTypes),
            'search_engine' => 'database',
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'query' => $schema->string()->description('Keywords or phrase to search across entity descriptions, articles, and properties.')->required(),
            'limit' => $schema->integer()->description('Maximum number of results to return, from 1 to 30 (default 15).'),
        ];
    }

    /**
     * @param  array<int, int|string>  $enabledEntityTypes
     * @return array<int, array<string, mixed>>
     */
    protected function searchMeilisearch(User $user, Campaign $campaign, string $query, int $limit, array $enabledEntityTypes): array
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $searchQuery = (new SearchQuery)
            ->setIndexUid('entities')
            ->setQuery($query)
            ->setFilter(['campaign_id = ' . $campaign->id])
            ->setAttributesToRetrieve(['id', 'entity_id', 'type'])
            ->setAttributesToHighlight(['name', 'entry'])
            ->setAttributesToCrop(['entry'])
            ->setCropLength(25)
            ->setHighlightPreTag('')
            ->setHighlightPostTag('')
            ->setLimit(40);

        $response = $client->multiSearch([$searchQuery]);
        $hits = $response['results'][0]['hits'] ?? [];
        if (empty($hits)) {
            return [];
        }

        $entityIds = array_values(array_unique(array_column($hits, 'entity_id')));
        /** @var Collection<int, Entity> $entities */
        $entities = Entity::query()
            ->with('entityType')
            ->where('campaign_id', $campaign->id)
            ->whereIn('type_id', $enabledEntityTypes)
            ->whereIn('id', $entityIds)
            ->get()
            ->keyBy('id');

        $postIds = collect($hits)
            ->filter(fn (array $hit): bool => ($hit['type'] ?? null) === 'post')
            ->map(fn (array $hit): int => (int) Str::afterLast((string) $hit['id'], '_'))
            ->filter()
            ->values();
        $accessiblePostIds = $postIds->isEmpty()
            ? collect()
            : Post::query()->whereIn('id', $postIds)->pluck('id');

        $attributeIds = collect($hits)
            ->filter(fn (array $hit): bool => ($hit['type'] ?? null) === 'attribute')
            ->map(fn (array $hit): int => (int) Str::afterLast((string) $hit['id'], '_'))
            ->filter()
            ->values();
        /** @var Collection<int, Attribute> $attributes */
        $attributes = $attributeIds->isEmpty()
            ? collect()
            : Attribute::query()->whereIn('id', $attributeIds)->get()->keyBy('id');

        $isAdmin = $user->can('admin', $campaign);
        $results = [];
        $seen = [];

        foreach ($hits as $hit) {
            if (count($results) >= $limit) {
                break;
            }

            /** @var ?Entity $entity */
            $entity = $entities->get($hit['entity_id']);
            if (! $entity || ! Gate::forUser($user)->allows('view', $entity)) {
                continue;
            }

            $hitType = (string) ($hit['type'] ?? 'entity');
            $dedupeKey = $entity->id . ':' . $hitType;

            if ($hitType === 'post') {
                $postId = (int) Str::afterLast((string) $hit['id'], '_');
                if (! $accessiblePostIds->contains($postId)) {
                    continue;
                }
                $dedupeKey .= ':' . $postId;
            } elseif ($hitType === 'attribute') {
                if (! Gate::forUser($user)->allows('viewAttributes', [$entity, $campaign])) {
                    continue;
                }
                $attrId = (int) Str::afterLast((string) $hit['id'], '_');
                $attr = $attributes->get($attrId);
                if (! $attr || ($attr->is_hidden && ! $isAdmin)) {
                    continue;
                }
                $dedupeKey .= ':' . $attrId;
            }

            if (isset($seen[$dedupeKey])) {
                continue;
            }
            $seen[$dedupeKey] = true;

            $rawSnippet = (string) ($hit['_formatted']['entry'] ?? $hit['_formatted']['name'] ?? '');
            $snippet = mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags($rawSnippet)) ?? ''), 0, 300);

            $results[] = [
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'module' => [
                    'id' => $entity->entityType->id,
                    'code' => $entity->entityType->code,
                    'name' => $entity->entityType->name(),
                ],
                'match_type' => $hitType,
                'snippet' => $snippet,
                'url' => $entity->url(),
            ];
        }

        return $results;
    }

    /**
     * @param  array<int, int|string>  $enabledEntityTypes
     * @return array<int, array<string, mixed>>
     */
    protected function searchDatabase(User $user, Campaign $campaign, string $query, int $limit, array $enabledEntityTypes): array
    {
        $escaped = '%' . addcslashes($query, '%_\\') . '%';
        $results = [];
        $seen = [];

        $entities = Entity::query()
            ->with('entityType')
            ->where('campaign_id', $campaign->id)
            ->whereIn('type_id', $enabledEntityTypes)
            ->where(function ($sub) use ($escaped): void {
                $sub->where('name', 'like', $escaped)
                    ->orWhere('entry', 'like', $escaped);
            })
            ->orderBy('name')
            ->limit($limit)
            ->get();

        foreach ($entities as $entity) {
            if (! Gate::forUser($user)->allows('view', $entity)) {
                continue;
            }

            $seen['entity:' . $entity->id] = true;
            $results[] = [
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'module' => [
                    'id' => $entity->entityType->id,
                    'code' => $entity->entityType->code,
                    'name' => $entity->entityType->name(),
                ],
                'match_type' => 'entity',
                'snippet' => $this->extractSnippet((string) ($entity->entry ?? ''), $query),
                'url' => $entity->url(),
            ];

            if (count($results) >= $limit) {
                return $results;
            }
        }

        $remaining = $limit - count($results);
        if ($remaining <= 0) {
            return $results;
        }

        $posts = Post::query()
            ->with('entity.entityType')
            ->whereHas('entity', function ($sub) use ($campaign, $enabledEntityTypes): void {
                $sub->where('campaign_id', $campaign->id)
                    ->whereIn('type_id', $enabledEntityTypes);
            })
            ->where(function ($sub) use ($escaped): void {
                $sub->where('name', 'like', $escaped)
                    ->orWhere('entry', 'like', $escaped);
            })
            ->orderByDesc('updated_at')
            ->limit($remaining * 2)
            ->get();

        foreach ($posts as $post) {
            $entity = $post->entity;
            if (! $entity || ! Gate::forUser($user)->allows('view', $entity)) {
                continue;
            }

            $key = 'post:' . $entity->id . ':' . $post->id;
            if (isset($seen[$key])) {
                continue;
            }
            $seen[$key] = true;

            $results[] = [
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'module' => [
                    'id' => $entity->entityType->id,
                    'code' => $entity->entityType->code,
                    'name' => $entity->entityType->name(),
                ],
                'match_type' => 'post',
                'post_name' => $post->name,
                'snippet' => $this->extractSnippet((string) ($post->entry ?? $post->name), $query),
                'url' => $entity->url(),
            ];

            if (count($results) >= $limit) {
                break;
            }
        }

        return $results;
    }

    protected function extractSnippet(string $html, string $query): string
    {
        $plain = trim(preg_replace('/\s+/', ' ', strip_tags($html)) ?? '');
        if ($plain === '') {
            return '';
        }

        $pos = mb_stripos($plain, $query);
        if ($pos === false) {
            return mb_substr($plain, 0, 240);
        }

        $start = max(0, $pos - 80);
        $excerpt = mb_substr($plain, $start, 240);

        return ($start > 0 ? '...' : '') . $excerpt . (mb_strlen($plain) > $start + 240 ? '...' : '');
    }
}
