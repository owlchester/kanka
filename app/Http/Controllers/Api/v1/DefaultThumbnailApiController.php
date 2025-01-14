<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Http\Requests\Campaigns\StoreDefaultThumbnail;
use App\Http\Requests\Campaigns\DestroyDefaultThumbnail;
use App\Http\Resources\EntityDefaultThumbnailResource as Resource;
use App\Models\EntityType;
use App\Services\Campaign\DefaultImageService;
use Illuminate\Support\Str;

class DefaultThumbnailApiController extends ApiController
{
    public function __construct(protected DefaultImageService $defaultImageService)
    {
        $this->middleware('campaign.boosted')->except('index');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign->defaultImages());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function upload(StoreDefaultThumbnail $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $entityType = EntityType::inCampaign($campaign)->find($request->post('entity_type_id'));
        if ($this->defaultImageService->campaign($campaign)->entityType($entityType)->save($request)) {
            return response()->json([
                'data' => 'Default thumbnail successfully uploaded'
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(DestroyDefaultThumbnail $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $entityType = EntityType::inCampaign($campaign)->find($request->post('entity_type_id'));
        $result = $this->defaultImageService->campaign($campaign)->entityType($entityType)->destroy();

        if ($result) {
            return response()->json([
                'data' => 'Default thumbnail successfully deleted'
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }
}
