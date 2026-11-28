<?php

namespace App\Mcp\Tools;

use App\Enums\Permission;
use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\User;
use App\Services\Entity\CreatorPermissionService;
use App\Services\Entity\StandardEntityCreationService;
use App\Services\EntityTypeService;
use App\Services\Permissions\EntityPermission;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;
use Stevebauman\Purify\Facades\Purify;

#[Description('Creates a new entity in an enabled campaign module (e.g., character, location, note, quest, item, organisation, or custom module). Defaults to private for campaign admins.')]
#[IsDestructive(false)]
class CreateEntityTool extends Tool
{
    use RecordsToolUsage;

    public function handle(
        Request $request,
        CampaignContext $context,
        EntityTypeService $entityTypes,
        StandardEntityCreationService $creationService,
    ): ResponseFactory {
        $this->recordUsage();

        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'module' => ['required', 'string', 'min:1', 'max:64'],
            'name' => ['required', 'string', 'min:1', 'max:191'],
            'type' => ['sometimes', 'nullable', 'string', 'max:191'],
            'entry' => ['sometimes', 'nullable', 'string', 'max:20000'],
            'is_private' => ['sometimes', 'boolean'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 401);

        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $enabledTypes = $entityTypes->campaign($campaign)->toSelect();

        $moduleCode = strtolower(trim((string) $arguments['module']));
        /** @var ?EntityType $entityType */
        $entityType = EntityType::query()
            ->whereIn('id', array_keys($enabledTypes))
            ->where('code', $moduleCode)
            ->first();

        if (! $entityType || (! $entityType->hasEntity() && ! $entityType->isCustom())) {
            throw ValidationException::withMessages([
                'module' => ["Module '{$moduleCode}' is not enabled or cannot be created via MCP."],
            ]);
        }

        abort_unless(
            app(EntityPermission::class)->canEntityType($entityType, Permission::Create, $user, $campaign),
            403
        );

        $isAdmin = $user->can('admin', $campaign);
        $isPrivate = $isAdmin ? (bool) ($arguments['is_private'] ?? true) : false;

        $entryHtml = filled($arguments['entry'] ?? null)
            ? Purify::clean(Str::markdown((string) $arguments['entry']))
            : null;

        $type = filled($arguments['type'] ?? null) ? trim((string) $arguments['type']) : null;
        $name = trim((string) $arguments['name']);

        if ($entityType->isStandard() && $entityType->hasEntity()) {
            $child = $creationService
                ->campaign($campaign)
                ->entityType($entityType)
                ->user($user)
                ->create([
                    'name' => $name,
                    'type' => $type,
                    'is_private' => $isPrivate,
                ]);

            $entity = $child->entity;
            if ($entryHtml !== null) {
                $entity->entry = $entryHtml;
                $entity->save();
            }
        } else {
            $entity = new Entity;
            $entity->campaign_id = $campaign->id;
            $entity->type_id = $entityType->id;
            $entity->name = $name;
            $entity->type = $type;
            $entity->entry = $entryHtml;
            $entity->is_private = $isPrivate;
            $entity->created_by = $user->id;
            $entity->setRelation('entityType', $entityType);
            $entity->save();

            app(CreatorPermissionService::class)
                ->entity($entity)
                ->user($user)
                ->grant();
        }

        return Response::structured([
            'id' => $entity->id,
            'campaign_id' => $campaign->id,
            'name' => $entity->name,
            'module' => [
                'id' => $entityType->id,
                'code' => $entityType->code,
                'name' => $entityType->name(),
            ],
            'type' => $entity->type,
            'is_private' => (bool) $entity->is_private,
            'url' => $entity->url(),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'module' => $schema->string()->description('Enabled module code (e.g. character, location, note, journal, quest, item, organisation, family, race, event, creature, or custom module code).')->required(),
            'name' => $schema->string()->description('Entity name.')->required(),
            'type' => $schema->string()->description('Optional entity subtype label (e.g. NPC, City, Guild).'),
            'entry' => $schema->string()->description('Optional Markdown description/entry content.'),
            'is_private' => $schema->boolean()->description('Whether the entity is private to admins. Defaults to true for campaign admins.'),
        ];
    }
}
