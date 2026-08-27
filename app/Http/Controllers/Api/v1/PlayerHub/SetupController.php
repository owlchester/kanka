<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\PlayerHubEntityResource;
use App\Services\PlayerHub\EntityQueryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupController extends ApiController
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $characters = $this->entityQueryService
            ->visibleTo($user)
            ->where('entities.type_id', config('entities.ids.character'));

        $claimed = (clone $characters)
            ->whereHas('claims', function ($query) use ($user): void {
                $query
                    ->where('user_id', $user->id)
                    ->whereNull('unclaimed_at');
            })
            ->with(['claims' => function ($query) use ($user): void {
                $query
                    ->where('user_id', $user->id)
                    ->whereNull('unclaimed_at')
                    ->withCount('playerSessions')
                    ->with('lastPlayedSession')
                    ->addSelect([
                        'interaction_entities_count' => DB::table('interaction_logs')
                            ->selectRaw('COUNT(DISTINCT interaction_logs.entity_id)')
                            ->whereColumn('interaction_logs.entity_claim_id', 'entity_claims.id'),
                    ]);
            }])
            ->get();

        $claimable = (clone $characters)
            ->where('entities.is_claimable', true)
            ->whereDoesntHave('claims', function ($query): void {
                $query->whereNull('unclaimed_at');
            })
            ->get();

        return response()->json([
            'claimed' => PlayerHubEntityResource::collection($claimed)->resolve($request),
            'claimable' => PlayerHubEntityResource::collection($claimable)->resolve($request),
            'sync' => Carbon::now(),
        ]);
    }
}
