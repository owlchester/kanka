<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Entity;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Gate;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Lists visible posts on an entity. Hidden posts and their counts are not disclosed.')]
#[IsReadOnly]
#[IsIdempotent]
class ListEntityPostsTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $this->recordUsage();
        $args = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'entity_id' => ['required', 'integer', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'query' => ['sometimes', 'string', 'max:100'],
        ]);
        $user = $request->user();
        abort_unless($user instanceof User, 401);
        $campaign = $context->campaign($user, (int) $args['campaign_id']);
        $entity = Entity::query()->where('campaign_id', $campaign->id)->findOrFail($args['entity_id']);
        Gate::forUser($user)->authorize('view', $entity);
        $page = (int) ($args['page'] ?? 1);
        $perPage = (int) ($args['per_page'] ?? 20);
        $query = $entity->posts()->orderBy('position')->orderBy('id');
        if (! empty($args['query'])) {
            $query->where('name', 'like', '%' . $args['query'] . '%');
        }
        $posts = $query->forPage($page, $perPage + 1)->get();
        $hasMore = $posts->count() > $perPage;

        return Response::structured([
            'items' => $posts->take($perPage)->map(fn (Post $post) => [
                'id' => $post->id,
                'name' => $post->name,
                'preview' => mb_substr(strip_tags((string) $post->entry), 0, 500),
                'updated_at' => $post->updated_at?->toIso8601String(),
            ])->values()->all(),
            'pagination' => ['page' => $page, 'per_page' => $perPage, 'has_more' => $hasMore],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->required(),
            'entity_id' => $schema->integer()->required(),
            'page' => $schema->integer(),
            'per_page' => $schema->integer(),
            'query' => $schema->string(),
        ];
    }
}
