<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Http\Requests\Campaigns\StoreDefaultThumbnail;
use App\Http\Requests\Campaigns\DestroyDefaultThumbnail;
use App\Http\Resources\DefaultImageResource as Resource;
use App\Services\Campaign\DefaultImageService;
use Illuminate\Support\Str;

class DefaultThumbnailApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return response()->json($campaign->getDefaultImages());
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function upload(StoreDefaultThumbnail $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        if ($campaign->premium()) {
            /** @var DefaultImageService $service */
            $service = app()->make(DefaultImageService::class);
            $type = Str::plural(array_search($request->post('entity_type'), config('entities.ids')));

            if ($service->campaign($campaign)->type($type)->save($request)) {
                return response()->json([
                    'data' => 'Default thumbnail succesfully uploaded'
                ]);
            }
        }
        return response()->json(['error' => 'Invalid input'], 422);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(DestroyDefaultThumbnail $request, Campaign $campaign)
    {
        if ($campaign->premium()) {
            /** @var DefaultImageService $service */
            $service = app()->make(DefaultImageService::class);
            $this->authorize('recover', $campaign);
            $type = Str::plural(array_search($request->post('entity_type'), config('entities.ids')));

            $result = $service->campaign($campaign)->type($type)->destroy();

            if ($result) {
                return response()->json([
                    'data' => 'Default thumbnail succesfully deleted'
                ]);
            }
        }
        return response()->json(['error' => 'Invalid input'], 422);
    }
}
