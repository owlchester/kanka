<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\StoreInteractionLog;
use App\Http\Resources\InteractionLogResource;
use App\Models\Entity;
use App\Models\InteractionLog;
use App\Models\PlayerSession;
use App\Services\PlayerHub\EntityQueryService;
use App\Services\PlayerHub\PlayerHubContextService;
use Illuminate\Http\Request;

class InteractionLogController extends ApiController
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
        protected PlayerHubContextService $playerHubContextService,
    ) {}

    public function index(Request $request, int $playerSession)
    {
        $session = $this->findSession($request, $playerSession);

        return InteractionLogResource::collection(
            $session->interactionLogs()
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate()
        );
    }

    public function store(StoreInteractionLog $request, int $playerSession)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('update', $session);
        $data = $request->validated();

        $interaction = new InteractionLog([
            'player_session_id' => $session->id,
            'entity_id' => $this->findVisibleEntity($request, $session, $data['entity_id'])->id,
            'note' => $data['note'],
            'visibility' => $data['visibility'] ?? null,
            'attitude' => $data['attitude'] ?? null,
        ]);
        $interaction->created_by = $request->user()->id;
        $interaction->save();

        return new InteractionLogResource($interaction->refresh());
    }

    public function show(Request $request, int $playerSession, int $interaction)
    {
        $session = $this->findSession($request, $playerSession);

        return new InteractionLogResource($this->findInteraction($session, $interaction));
    }

    public function update(StoreInteractionLog $request, int $playerSession, int $interaction)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('update', $session);
        $log = $this->findInteraction($session, $interaction);
        $data = $request->validated();

        if (array_key_exists('entity_id', $data)) {
            $data['entity_id'] = $this->findVisibleEntity($request, $session, $data['entity_id'])->id;
        }

        $log->update($data);

        return new InteractionLogResource($log->refresh());
    }

    public function destroy(Request $request, int $playerSession, int $interaction)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('update', $session);
        $this->findInteraction($session, $interaction)->delete();

        return response()->json(null, 204);
    }

    public function recover(Request $request, int $playerSession, int $interaction)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('restore', $session);
        $log = $this->findInteraction($session, $interaction, true);
        $log->restore();

        return new InteractionLogResource($log->refresh());
    }

    protected function findSession(Request $request, int $playerSession): PlayerSession
    {
        $context = $this->playerHubContextService->forSession($request->user(), $playerSession);
        $this->playerHubContextService->activate($context);
        $session = $context->session;
        if (! $session instanceof PlayerSession) {
            abort(404);
        }
        $this->authorize('view', $session);

        return $session;
    }

    protected function findInteraction(PlayerSession $session, int $interaction, bool $withTrashed = false): InteractionLog
    {
        return $session->interactionLogs()
            ->when($withTrashed, fn ($query) => $query->withTrashed())
            ->whereKey($interaction)
            ->firstOrFail();
    }

    protected function findVisibleEntity(Request $request, PlayerSession $session, int $entityId): Entity
    {
        $context = $this->playerHubContextService->forClaim(
            $request->user(),
            $session->entity_claim_id,
        );
        $this->playerHubContextService->activate($context);

        return $this->entityQueryService
            ->visibleTo($request->user())
            ->where('entities.campaign_id', $context->campaign->id)
            ->whereKey($entityId)
            ->firstOrFail();
    }
}
