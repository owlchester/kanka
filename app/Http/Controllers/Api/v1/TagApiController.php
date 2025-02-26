<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Tag;
use App\Http\Requests\StoreTag as Request;
use App\Http\Resources\TagResource as Resource;

class TagApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->tags()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $tag->entity);
        return new Resource($tag);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.tag')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Tag::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $tag->entity);
        $tag->update($request->all());
        $this->crudSave($tag);

        return new Resource($tag);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $tag->entity);
        $tag->delete();

        return response()->json(null, 204);
    }
}
