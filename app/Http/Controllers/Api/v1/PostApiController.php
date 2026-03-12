<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StorePost as Request;
use App\Http\Resources\PostResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->posts()->with('permissions')->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($post);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $model = Post::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $post->update($request->all());

        return new Resource($post);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        Post $post
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $post->delete();

        return response()->json(null, 204);
    }
}
