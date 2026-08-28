<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\InteractionLogResource;
use App\Http\Resources\PlayerHubEntityDetailResource;
use App\Services\PlayerHub\EntityQueryService;
use App\Services\PlayerHub\PlayerHubContextService;
use Illuminate\Http\Request;

class EntityController extends ApiController
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
        protected PlayerHubContextService $playerHubContextService,
    ) {}

    public function show(Request $request, int $entity)
    {
        $data = $request->validate([
            'entity_claim_id' => ['required', 'integer'],
        ]);
        $user = $request->user();
        $context = $this->playerHubContextService->forClaim($user, $data['entity_claim_id']);
        $this->playerHubContextService->activate($context);

        $model = $this->entityQueryService
            ->visibleTo($user)
            ->where('entities.campaign_id', $context->campaign->id)
            ->whereKey($entity)
            ->firstOrFail();
        $model->load([
            'locations.entity',
            'character.characterFamilies.family.entity',
            'character.organisationMemberships.organisation.entity',
        ]);

        $interactions = $context->claim
            ->interactionLogs()
            ->where('interaction_logs.entity_id', $model->id)
            ->visibleToPlayer($context->campaign)
            ->with(['entity.campaign', 'playerSession'])
            ->orderByDesc('interaction_logs.created_at')
            ->orderByDesc('interaction_logs.id')
            ->paginate()
            ->appends($request->except('page'));

        $interactionData = InteractionLogResource::collection($interactions)
            ->toResponse($request)
            ->getData(true);
        unset($interactionData['sync'], $interactionData['queries']);

        $entityData = (new PlayerHubEntityDetailResource($model))->resolve($request);
        $entityData['interactions'] = $interactionData;

        return response()->json([
            'data' => $entityData,
            'sync' => now(),
        ]);
    }
}
