<?php

namespace App\Mcp\Tools;

use App\Enums\Visibility;
use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Entity;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;
use Stevebauman\Purify\Facades\Purify;

#[Description('Creates a relationship link between two visible entities in a campaign. Defaults to admin-only visibility for campaign admins.')]
#[IsDestructive(false)]
class CreateRelationTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $this->recordUsage();

        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'owner_entity_id' => ['required', 'integer', 'min:1'],
            'target_entity_id' => ['required', 'integer', 'min:1'],
            'relation' => ['required', 'string', 'min:1', 'max:191'],
            'attitude' => ['sometimes', 'integer', 'min:-100', 'max:100'],
            'visibility' => ['sometimes', 'string', 'in:admin,all,self'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 401);

        if ((int) $arguments['owner_entity_id'] === (int) $arguments['target_entity_id']) {
            throw ValidationException::withMessages([
                'target_entity_id' => ['Target entity must be different from owner entity.'],
            ]);
        }

        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);

        $owner = Entity::query()
            ->where('campaign_id', $campaign->id)
            ->findOrFail((int) $arguments['owner_entity_id']);
        $target = Entity::query()
            ->where('campaign_id', $campaign->id)
            ->findOrFail((int) $arguments['target_entity_id']);

        Gate::forUser($user)->authorize('update', $owner);
        Gate::forUser($user)->authorize('view', $target);

        $isAdmin = $user->can('admin', $campaign);
        $requestedVisibility = (string) ($arguments['visibility'] ?? ($isAdmin ? 'admin' : 'all'));

        $visibility = match ($requestedVisibility) {
            'self' => Visibility::Self,
            'admin' => $isAdmin ? Visibility::Admin : Visibility::All,
            default => Visibility::All,
        };

        $relation = Relation::create([
            'campaign_id' => $campaign->id,
            'owner_id' => $owner->id,
            'target_id' => $target->id,
            'relation' => trim(strip_tags(Purify::clean((string) $arguments['relation']))),
            'attitude' => (int) ($arguments['attitude'] ?? 0),
            'visibility_id' => $visibility,
        ]);

        return Response::structured([
            'id' => $relation->id,
            'owner_entity_id' => $owner->id,
            'target_entity_id' => $target->id,
            'relation' => $relation->relation,
            'attitude' => $relation->attitude,
            'visibility' => $visibility->value,
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'owner_entity_id' => $schema->integer()->description('Source entity ID.')->required(),
            'target_entity_id' => $schema->integer()->description('Target entity ID.')->required(),
            'relation' => $schema->string()->description('Relationship label (e.g. "owes gold to", "ally of").')->required(),
            'attitude' => $schema->integer()->description('Optional attitude score from -100 to 100 (default 0).'),
            'visibility' => $schema->string()->description('Visibility: admin (default for admins), all, or self.'),
        ];
    }
}
