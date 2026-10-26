<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Models\Entity;
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

#[Description('Lists visible outgoing relationships from a visible entity. Hidden targets are omitted. This does not list incoming relationships.')]
#[IsReadOnly]
#[IsIdempotent]
class GetEntityRelationsTool extends Tool
{
    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'entity_id' => ['required', 'integer', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1', 'max:1000'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);
        $user = $request->user();
        abort_unless($user instanceof User, 401);
        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $entity = Entity::query()->where('campaign_id', $campaign->id)->findOrFail($arguments['entity_id']);
        Gate::forUser($user)->authorize('view', $entity);

        $relations = $entity->relationships()->with(['target.entityType'])->has('target')->paginate(
            (int) ($arguments['per_page'] ?? 15),
            ['*'],
            'page',
            (int) ($arguments['page'] ?? 1),
        );
        $results = $relations->getCollection()->filter(function ($relation) use ($user) {
            return $relation->target && Gate::forUser($user)->allows('view', $relation->target);
        })->map(fn ($relation) => [
            'id' => $relation->id,
            'label' => $relation->relation,
            'target' => [
                'id' => $relation->target->id,
                'name' => $relation->target->name,
                'module' => $relation->target->entityType->code,
                'url' => $relation->target->url(),
            ],
        ])->values()->all();

        return Response::structured([
            'results' => $results,
            'pagination' => ['page' => $relations->currentPage(), 'per_page' => $relations->perPage()],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'entity_id' => $schema->integer()->description('Kanka entity ID.')->required(),
            'page' => $schema->integer()->description('Page number, starting at 1.'),
            'per_page' => $schema->integer()->description('Results per page, from 1 to 50.'),
        ];
    }
}
