<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Facades\EntityCache;
use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\PlayerHubEntityResource;
use App\Models\Entity;
use App\Models\EntityClaim;
use App\Models\Scopes\AclScope;
use App\Models\Scopes\CampaignScope;
use App\Services\PlayerHub\EntityQueryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends ApiController
{
    public function __construct(
        protected EntityQueryService $entityQueryService,
    ) {}

    public function store(Request $request, int $entity): JsonResponse|PlayerHubEntityResource
    {
        $claim = DB::transaction(function () use ($request, $entity): EntityClaim|false {
            $model = $this->entityQueryService
                ->visibleTo($request->user())
                ->where('entities.id', $entity)
                ->lockForUpdate()
                ->first();

            if (! $model instanceof Entity) {
                return false;
            }

            if (! $model->is_claimable || $model->claims()->whereNull('unclaimed_at')->exists()) {
                return false;
            }

            EntityCache::campaign($model->campaign);

            $claim = EntityClaim::create([
                'entity_id' => $model->id,
                'user_id' => $request->user()->id,
                'claimed_at' => now(),
            ]);

            $model->update(['is_claimable' => false]);

            return $claim;
        });

        if ($claim === false) {
            $visible = $this->entityQueryService
                ->visibleTo($request->user())
                ->where('entities.id', $entity)
                ->exists();

            return response()->json([
                'message' => $visible ? __('entities/claims.unavailable') : 'Not found.',
            ], $visible ? 409 : 404);
        }

        /** @var Entity $model */
        $model = Entity::query()
            ->withoutGlobalScopes([
                AclScope::class,
                CampaignScope::class,
            ])
            ->with([
                'campaign',
                'entityType',
                'claims' => function ($query): void {
                    $query->whereNull('unclaimed_at');
                },
            ])
            ->findOrFail($claim->entity_id);
        $model->setRelation('claims', new Collection([$claim]));

        return (new PlayerHubEntityResource($model))
            ->response()
            ->setStatusCode(201);
    }
}
