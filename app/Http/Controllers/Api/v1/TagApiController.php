<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreTag as Request;
use App\Http\Resources\TagResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Tag;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagApiController extends MiscApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @return resource
     */
    public function show(Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $tag->entity);

        return new Resource($tag);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.tag')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Tag::create($data);
        $this->crudSave($model, $request->validated());

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $tag->entity);
        $tag->update($request->all());
        $this->crudSave($tag, $request->validated());

        return new Resource($tag);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Tag $tag)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $tag->entity);
        $tag->delete();

        return response()->json(null, 204);
    }
}
