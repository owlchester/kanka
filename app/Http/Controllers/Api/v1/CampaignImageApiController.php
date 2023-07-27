<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Campaigns\GalleryImageUpdate;
use App\Models\Campaign;
use App\Models\Image;
use App\Http\Requests\Campaigns\GalleryImageStore as Request;
use App\Http\Resources\ImageResource as Resource;
use App\Services\Campaign\GalleryService;
use Illuminate\Support\Arr;

class CampaignImageApiController extends ApiController
{
    protected GalleryService $service;

    public function __construct(GalleryService $galleryService)
    {
        $this->middleware('campaign.superboosted');
        $this->service = $galleryService;
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection(
            $campaign
                ->images()
                ->where('is_default', false)
                ->defaultOrder()
                ->lastSync(request()->get('lastSync'))
                ->paginate()
        );
    }

    /**
     * @param Campaign $campaign
     * @param Image $image
     * @return Resource
     */
    public function show(Campaign $campaign, Image $image)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        return new Resource($image);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $images = $this->service
            ->campaign($campaign)
            ->store($request);
        return new Resource(Arr::first($images));
    }

    /**
     * @param GalleryImageUpdate $request
     * @param Campaign $campaign
     * @param Image $image
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(GalleryImageUpdate $request, Campaign $campaign, Image $image)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $image->update($request->all());

        return new Resource($image);
    }

    /**
     * @param Campaign $campaign
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Image $image)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);
        $image->delete();

        return response()->json(null, 204);
    }
}
