<?php

namespace App\Mcp\Tools;

use App\Mcp\Services\CampaignContext;
use App\Mcp\Tools\Concerns\RecordsToolUsage;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsIdempotent;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Lists worlds (campaigns) that the connected user is currently a member of. Use this first to find a campaign ID for other tools.')]
#[IsReadOnly]
#[IsIdempotent]
class ListCampaignsTool extends Tool
{
    use RecordsToolUsage;

    public function handle(Request $request, CampaignContext $context): ResponseFactory
    {
        $this->recordUsage();
        $arguments = $request->validate([
            'page' => ['sometimes', 'integer', 'min:1', 'max:1000'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);
        $user = $request->user();
        abort_unless($user instanceof User, 401);

        $campaigns = $context->memberCampaigns($user)->paginate(
            (int) ($arguments['per_page'] ?? 15),
            ['campaigns.id', 'campaigns.name', 'campaigns.slug'],
            'page',
            (int) ($arguments['page'] ?? 1),
        );

        return Response::structured([
            'campaigns' => $campaigns->getCollection()->map(fn ($campaign) => [
                'id' => $campaign->id,
                'name' => $campaign->name,
                'url' => route('dashboard', $campaign),
            ])->all(),
            'pagination' => ['page' => $campaigns->currentPage(), 'per_page' => $campaigns->perPage(), 'total' => $campaigns->total(), 'last_page' => $campaigns->lastPage()],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'page' => $schema->integer()->description('Page number, starting at 1.'),
            'per_page' => $schema->integer()->description('Results per page, from 1 to 50.'),
        ];
    }
}
