<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\StorePlayerSession;
use App\Http\Resources\PlayerSessionResource;
use App\Models\EntityClaim;
use App\Models\PlayerSession;
use App\Services\PlayerHub\EntityQueryService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PlayerSessionController extends ApiController
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
    ) {}

    public function index(Request $request)
    {
        return PlayerSessionResource::collection(
            $this->entityQueryService
                ->activeSessionsFor($request->user())
                ->with('interactionLogs')
                ->when($request->filled('entity_claim_id'), fn ($query) => $query->where(
                    'player_sessions.entity_claim_id',
                    $request->integer('entity_claim_id'),
                ))
                ->orderByDesc('started_at')
                ->orderByDesc('id')
                ->paginate()
        );
    }

    public function store(StorePlayerSession $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $session = DB::transaction(function () use ($data, $user): PlayerSession {
            /** @var EntityClaim $claim */
            $claim = $this->entityQueryService
                ->activeClaimsFor($user)
                ->whereKey($data['entity_claim_id'])
                ->lockForUpdate()
                ->firstOrFail();
            $this->authorize('create', [PlayerSession::class, $claim]);
            $number = ((int) PlayerSession::query()
                ->where('entity_claim_id', $claim->id)
                ->max('number')) + 1;

            $session = new PlayerSession;
            $session->entity_claim_id = $claim->id;
            $session->created_by = $user->id;
            $session->number = $number;
            $session->name = $data['name'] ?? __('player-hub.session_name', ['number' => $number]);
            $session->started_at = $data['started_at'] ?? now();
            $session->ended_at = $data['ended_at'] ?? null;
            $session->summary = $data['summary'] ?? null;
            $session->save();

            return $session;
        });

        return new PlayerSessionResource($session->load('interactionLogs'));
    }

    public function show(Request $request, int $playerSession)
    {
        return new PlayerSessionResource($this->findSession($request, $playerSession));
    }

    public function update(StorePlayerSession $request, int $playerSession)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('update', $session);
        $session->update(Arr::except($request->validated(), ['entity_claim_id']));

        return new PlayerSessionResource($session->refresh()->load('interactionLogs'));
    }

    public function destroy(Request $request, int $playerSession)
    {
        $session = $this->findSession($request, $playerSession);
        $this->authorize('delete', $session);
        $session->delete();

        return response()->json(null, 204);
    }

    protected function findSession(Request $request, int $playerSession): PlayerSession
    {
        $session = $this->entityQueryService
            ->activeSessionsFor($request->user())
            ->with('interactionLogs')
            ->whereKey($playerSession)
            ->firstOrFail();
        $this->authorize('view', $session);

        return $session;
    }
}
