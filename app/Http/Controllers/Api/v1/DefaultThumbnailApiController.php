<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Http\Requests\Campaigns\StoreDefaultThumbnail;
use App\Http\Requests\Campaigns\DestroyDefaultThumbnail;
use App\Http\Resources\EntityDefaultThumbnailResource as Resource;
use App\Services\Campaign\DefaultImageService;
use Illuminate\Support\Str;

class DefaultThumbnailApiController extends ApiController
{
    protected DefaultImageService $service;

    public function __construct(DefaultImageService $defaultImageService)
    {
        $this->service = $defaultImageService;
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

        $type = Str::plural(array_search($request->post('entity_type_id'), config('entities.ids')));
        if ($this->service->campaign($campaign)->type($type)->save($request)) {
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

        $type = Str::plural(array_search($request->post('entity_type_id'), config('entities.ids')));
        $result = $this->service->campaign($campaign)->type($type)->destroy();

        if ($result) {
            return response()->json([
                'data' => 'Default thumbnail successfully deleted'
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }
}
