<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Services\PlayerHub\PlayerHubContextService;
use App\Services\Search\MentionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends ApiController
{
    public function __construct(
        protected PlayerHubContextService $playerHubContextService,
        protected MentionService $service,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'entity_claim_id' => ['required', 'integer'],
            'q' => ['required', 'string', 'max:191'],
        ]);
        $user = $request->user();
        $context = $this->playerHubContextService->forClaim($user, $data['entity_claim_id']);
        $this->playerHubContextService->activate($context);

        return response()->json(
            $this->service
                ->user($user)
                ->request($request)
                ->campaign($context->campaign)
                ->playerHub()
                ->search()
        );
    }
}
