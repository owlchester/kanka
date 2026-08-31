<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\PlayerHubMeResource;
use App\Services\PlayerHub\PlayerHubContextService;
use Illuminate\Http\Request;

class MeController extends ApiController
{
    public function __construct(
        protected PlayerHubContextService $playerHubContextService,
    ) {}

    public function show(Request $request)
    {
        $data = $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);
        $context = $this->playerHubContextService->forClaim(
            $request->user(),
            (int) $data['claim_id'],
        );
        $this->playerHubContextService->activate($context);

        $entity = $context->claimedEntity;
        $entity->load([
            'locations.entity',
            'character.races.entity',
            'character.families.entity',
            'character.organisations.entity',
            'relationships' => fn ($query) => $query->has('target'),
        ]);
        $entity->setRelation('observations', $context->claim
            ->interactionLogs()
            ->where('interaction_logs.entity_id', $entity->id)
            ->visibleToPlayer($context->campaign)
            ->with(['entity.campaign', 'playerSession', 'creator'])
            ->orderByDesc('interaction_logs.created_at')
            ->orderByDesc('interaction_logs.id')
            ->limit(30)
            ->get());

        return response()->json([
            'data' => (new PlayerHubMeResource($entity))->resolve($request),
            'sync' => now(),
        ]);
    }
}
