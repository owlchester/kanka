<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\StorePost as Request;
use App\Http\Resources\PostResource as Resource;
use App\Models\Post;

class PostApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return Resource::collection($entity->posts()->with('permissions')->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Post $post
     * @return Resource
     */
    public function show(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity->child);
        return new Resource($post);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $model = Post::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Post $post
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $post->update($request->all());

        return new Resource($post);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Entity $entity
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        Post $post
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity->child);
        $post->delete();

        return response()->json(null, 204);
    }
}
