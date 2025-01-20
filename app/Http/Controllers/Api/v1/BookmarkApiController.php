<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Bookmark;
use App\Http\Requests\StoreBookmark as Request;
use App\Http\Resources\BookmarkResource as Resource;

class BookmarkApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->bookmarks()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $bookmark);
        return new Resource($bookmark);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Bookmark::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        /** @var Bookmark $model */
        $model = Bookmark::create($data);

        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $bookmark);
        $bookmark->update($request->all());

        return new Resource($bookmark);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $bookmark->entity);
        $bookmark->delete();

        return response()->json(null, 204);
    }
}
