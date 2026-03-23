<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityTypeService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchApiController extends ApiController
{
    public function __construct(protected EntityTypeService $entityTypeService) {}

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Request $request, Campaign $campaign, ?string $search = null)
    {
        $this->authorize('access', $campaign);

        $term = mb_trim($search);
        $enabledEntities = array_keys($this->entityTypeService->campaign($campaign)->toSelect());
        $models = Entity::with(['entityType', 'image'])
            ->whereIn('type_id', $enabledEntities)
            ->where('name', 'like', "%{$term}%")
            ->limit(10)
            ->get();

        return \App\Http\Resources\Entity::collection($models);
    }
}
