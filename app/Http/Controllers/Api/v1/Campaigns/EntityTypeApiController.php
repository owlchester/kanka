<?php

namespace App\Http\Controllers\Api\v1\Campaigns;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Middleware\Campaigns\Premium;
use App\Http\Requests\StoreEntityType;
use App\Http\Resources\EntityTypeResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\EntityTypeService;
use Illuminate\Http\Request;

class EntityTypeApiController extends ApiController
{
    public function __construct(
        protected EntityTypeService $entityTypeService
    ) {
        $this->middleware(Premium::class, ['except' => ['index', 'show']]);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
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
        if ($entityType->campaign_id !== $campaign->id) {
            abort(403);
        }

        return new Resource($entityType);
    }

    public function store(StoreEntityType $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        $error = '. Consider upgrading to a higher tier to unlock a higher limit';

        $limit = config('limits.campaigns.modules.premium');
        if ($campaign->isWyvern()) {
            $limit = config('limits.campaigns.modules.wyvern');
        } elseif ($campaign->isElemental()) {
            $limit = config('limits.campaigns.modules.elemental');
            $error = '';
        }

        if ($campaign->entityTypes->count() >= $limit) {
            return response()->json(['error' => 'Max number of custom modules reached (:count/:max)' . $error, [
                'count' => $campaign->entityTypes->count(),
                'max' => $limit,
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

    public function destroy(Request $request, Campaign $campaign, EntityType $entityType)
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
