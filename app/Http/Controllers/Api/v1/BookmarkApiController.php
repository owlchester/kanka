<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreBookmark as Request;
use App\Http\Resources\BookmarkResource as Resource;
use App\Models\Bookmark;
use App\Models\Campaign;

class BookmarkApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
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
     * @return resource
     */
    public function show(Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $bookmark);

        return new Resource($bookmark);
    }

    /**
     * @return resource
     *
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
     * @return resource
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
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $bookmark);
        $bookmark->delete();

        return response()->json(null, 204);
    }
}
