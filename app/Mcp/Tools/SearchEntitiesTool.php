<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Entity;
use App\Models\User;
use App\Services\EntityTypeService;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Finds visible entities by name in a campaign. Searches names only, not entity entry text. Returns concise results; use get_entity for full entry content.')]
#[IsReadOnly]
#[IsIdempotent]
class SearchEntitiesTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context, EntityTypeService $entityTypes): ResponseFactory
    {
        $this->recordUsage();
        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'query' => ['required', 'string', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1', 'max:1000'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);
        $user = $request->user();
        abort_unless($user instanceof User, 401);
        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $enabledEntityTypes = array_keys($entityTypes->campaign($campaign)->toSelect());

        $entities = Entity::query()
            ->with('entityType')
            ->where('campaign_id', $campaign->id)
            ->whereIn('type_id', $enabledEntityTypes)
            ->where('name', 'like', '%' . addcslashes($arguments['query'], '%_\\') . '%')
            ->orderBy('name')
            ->orderBy('id')
            ->paginate((int) ($arguments['per_page'] ?? 15), ['*'], 'page', (int) ($arguments['page'] ?? 1));

        return Response::structured([
            'results' => $entities->getCollection()->map(fn (Entity $entity) => [
                'id' => $entity->id,
                'name' => $entity->name,
                'module' => ['id' => $entity->entityType->id, 'code' => $entity->entityType->code, 'name' => $entity->entityType->name()],
                'url' => $entity->url(),
            ])->all(),
            'pagination' => ['page' => $entities->currentPage(), 'per_page' => $entities->perPage(), 'total' => $entities->total(), 'last_page' => $entities->lastPage()],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'query' => $schema->string()->description('Entity name or partial name to find.')->required(),
            'page' => $schema->integer()->description('Page number, starting at 1.'),
            'per_page' => $schema->integer()->description('Results per page, from 1 to 50.'),
        ];
    }
}
