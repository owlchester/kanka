<?php

namespace App\Http\Controllers\Api\v1\Campaigns;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Middleware\PremiumCampaign;
use App\Http\Requests\StoreEntityType;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Http\Resources\EntityTypeResource as Resource;
use App\Services\EntityTypeService;
use Illuminate\Http\Request;

class EntityTypeApiController extends ApiController
{
    public function __construct(
        protected EntityTypeService $entityTypeService
    ) {
        $this->middleware(PremiumCampaign::class, ['except' => ['index', 'show']]);
    }
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection(EntityType::inCampaign($campaign)->paginate());
    }

    public function show(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('access', $campaign);
        return new Resource($entityType);
    }

    public function store(StoreEntityType $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        if ($campaign->entityTypes->count() >= config('limits.campaigns.modules')) {
            return response()->json(['error' => 'Max number of custom modules reached (:count/:max)', [
                'count' => $campaign->entityTypes->count(),
                'max' => config('limits.campaigns.modules')
            ]], 401);
        }

        $entityType = $this->entityTypeService
            ->campaign($campaign)
            ->request($request)
            ->save();

        return new Resource($entityType);
    }

    public function update(StoreEntityType $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('update', [$entityType, $campaign]);

        $entityType = $this->entityTypeService
            ->campaign($campaign)
            ->request($request)
            ->entityType($entityType)
            ->save();

        return new Resource($entityType);
    }

    public function delete(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('setting', $campaign);
        $this->authorize('delete', [$entityType, $campaign]);

        $this->entityTypeService
            ->campaign($campaign)
            ->entityType($entityType)
            ->delete();

        return response()->json(null, 204);
    }
}
