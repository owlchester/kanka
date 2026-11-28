<?php

namespace App\Mcp\Tools;

use App\Enums\Visibility;
use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\Entity;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsDestructive;
use Stevebauman\Purify\Facades\Purify;

#[Description('Adds a new article (post) to an existing entity without modifying existing content. Defaults to admin-only visibility for campaign admins.')]
#[IsDestructive(false)]
class AddEntityPostTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $this->recordUsage();

        $arguments = $request->validate([
            'campaign_id' => ['required', 'integer', 'min:1'],
            'entity_id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'min:1', 'max:191'],
            'entry' => ['required', 'string', 'min:1', 'max:20000'],
            'visibility' => ['sometimes', 'string', 'in:admin,all,self'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 401);

        $campaign = $context->campaign($user, (int) $arguments['campaign_id']);
        $entity = Entity::query()
            ->where('campaign_id', $campaign->id)
            ->findOrFail((int) $arguments['entity_id']);

        Gate::forUser($user)->authorize('post', [$entity, 'add']);

        $isAdmin = $user->can('admin', $campaign);
        $requestedVisibility = (string) ($arguments['visibility'] ?? ($isAdmin ? 'admin' : 'all'));

        $visibility = match ($requestedVisibility) {
            'self' => Visibility::Self,
            'admin' => $isAdmin ? Visibility::Admin : Visibility::All,
            default => Visibility::All,
        };

        $post = new Post;
        $post->entity_id = $entity->id;
        $post->name = trim((string) $arguments['name']);
        $post->entry = Purify::clean(Str::markdown((string) $arguments['entry']));
        $post->visibility_id = $visibility;
        $post->position = ((int) $entity->posts()->max('position')) + 1;
        $post->created_by = $user->id;
        $post->save();

        return Response::structured([
            'id' => $post->id,
            'entity_id' => $entity->id,
            'name' => $post->name,
            'visibility' => $visibility->value,
            'entity_url' => $entity->url(),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'campaign_id' => $schema->integer()->description('ID returned by list_campaigns.')->required(),
            'entity_id' => $schema->integer()->description('Target entity ID.')->required(),
            'name' => $schema->string()->description('Article title.')->required(),
            'entry' => $schema->string()->description('Article content in Markdown.')->required(),
            'visibility' => $schema->string()->description('Visibility: admin (default for admins), all, or self.'),
        ];
    }
}
